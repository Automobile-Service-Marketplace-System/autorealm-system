<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\Order;
use app\models\ShoppingCart;
use app\models\Customer;
use app\utils\DevOnly;

use Exception;
use JsonException;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Customer as StripeCustomer;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentsController
{
    public function getCheckoutPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {

            $customerId = $req->session->get("user_id");
            $cartModel = new ShoppingCart();
            $result = $cartModel->getCartItemsByCustomerId(customerId: $customerId);
            //            DevOnly::prettyEcho($result);
            if (is_string($result)) {
                return $res->redirect(path: "/cart");
            }

            if (empty($result)) {
                return $res->redirect(path: "/cart");
            }
            return $res->render(view: "site-cart-checkout", pageParams: [
                'cartItems' => $result
            ], layoutParams: [
                'title' => 'Checkout',
                'pageMainHeading' => 'Checkout',
                'customerId' => $req->session->get("user_id"),
            ]);
        } else {
            return $res->redirect(path: "/login");
        }
    }

    /**
     * @throws ApiErrorException
     * @throws JsonException
     */
    public function checkoutProductAndChargeCustomer(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $body = $req->body();
            $stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];
            Stripe::setApiKey($stripeSecretKey);

            $customerId = $req->session->get("user_id");

            $shoppingCartModel = new ShoppingCart();
            $totalCost = $shoppingCartModel->calculateCartTotalCost($customerId);


            $customerModel = new Customer();
            $customer = $customerModel->getCustomerById($customerId);

            if (!$customer) {
                $res->setStatusCode(code: 401);
                return $res->json(['message' => "You are not authorized to perform this action"]);
            }

            if (is_string($totalCost)) {
                $res->setStatusCode(code: 500);
                return $res->json(['message' => $totalCost]);
            }

            // check if stripe has a customer with the $customer->email
            // if not, create a new customer
            // if yes, get the customer id and use it to create a payment intent
            $stripeCustomer = null;
            try {
                if (!$customer->payment_id) {
                    throw new Exception("No payment id");
                }

                $stripeCustomer = StripeCustomer::retrieve([
                    'id' => $customer->payment_id,
                ]);
                $stripeCustomerId = $stripeCustomer->id;
            } catch (Exception $e) {
                if (($e instanceof ApiErrorException && $e->getStripeCode() === "resource_missing") || !$customer->payment_id) {
                    $stripeCustomer = StripeCustomer::create([
                        'email' => $customer->email,
                        'name' => $customer->f_name . " " . $customer->l_name,
                        'phone' => $customer->contact_no
                    ]);
                    $stripeCustomerId = $stripeCustomer->id;
                    $result = $customerModel->setPaymentId($customerId, $stripeCustomerId);
                    if (is_string($result)) {
                        $res->setStatusCode(code: 500);
                        return $res->json(['message' => $result]);
                    }
                } else {
                    $res->setStatusCode(code: 500);
                    return $res->json(['message' => $e->getMessage()]);
                }
            }


            $paymentIntent = PaymentIntent::create([
                'amount' => $totalCost,
                'currency' => 'lkr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'customer' => $stripeCustomerId,
                'receipt_email' => $customer->email,
            ]);
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            $res->setStatusCode(code: 200);
            return $res->json($output);
        } else {
            return $res->redirect(path: "/login");
        }
    }


    /**
     * @throws JsonException
     */
    public function verifyPayments(Request $req, Response $res): string
    {
        // log body of request to ROOT_DIR/logs/payment-verifications.md
        $body = $req->body();

        $type = $body['type'];
        if ($type === 'payment_intent.succeeded') {
            $stripeCustomerId = $body['data']['object']['customer'];
            $amount = $body['data']['object']['amount'];

            $customerModel = new Customer();
            $customer = $customerModel->getCustomerByPaymentId($stripeCustomerId);
            if ($customer) {

                $orderModel = new Order();
                $orderCreationResult = $orderModel->createOrder(customerId: $customer->customer_id);
                if (is_string($orderCreationResult)) {


                    // this means the order creation failed
                    // refund the customer
                    $stripeSecretKey = $_ENV['STRIPE_SECRET_KEY'];
                    Stripe::setApiKey($stripeSecretKey);

                    try {
                        $paymentIntent = PaymentIntent::retrieve($body['data']['object']['id']);
                        $stripeClient = new StripeClient([
                            'api_key' => $stripeSecretKey,
                        ]);
                        $stripeClient->refunds->create([
                            'payment_intent' => $paymentIntent->id,
                            'amount' => $amount,
                        ]);
                    } catch (ApiErrorException $e) {
                        $res->setStatusCode(code: 500);
                        return $res->json(['message' => "Order creation failed and refund failed. Please contact use to get your money back"]);
                    }

                    $res->setStatusCode(code: 500);
                    return $res->json(['message' => $orderCreationResult]);
                } else {
                    $shoppingCartModel = new ShoppingCart();
                    $shoppingCartModel->clearCart(customer_id: $customer->customer_id);

                    if (is_string($orderCreationResult)) {
                        $res->setStatusCode(code: 500);
                        return $res->json(['message' => $orderCreationResult]);
                    }

                    return $res->json(['message' => 'success']);
                }

            }


        }

        $logFile = fopen(Application::$rootDir . "/logs/payment-verifications.md", "a");
        fwrite($logFile, "## " . date("Y-m-d H:i:s") . "\n\n");
        fwrite($logFile, "```json\n");
        // pretty print json
        fwrite($logFile, json_encode($body, JSON_PRETTY_PRINT));
        fwrite($logFile, "\n```\n\n");
        fclose($logFile);
        return $res->json(['message' => 'success']);
    }



    public function getCheckoutSuccessPage(Request $req, Response $res): string
    {
        if ($req->session->get("is_authenticated") && $req->session->get("user_role") === "customer") {
            $customerId = $req->session->get("user_id");
            return $res->render(view: "site-order-received",
                layoutParams: ['title' => 'Order Received', 'customerId' => $customerId]);
        }
        return $res->redirect(path: "/login");
    }
}