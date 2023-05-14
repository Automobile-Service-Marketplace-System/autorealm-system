import {loadStripe} from '@stripe/stripe-js'

/**
 *
 * @type {HTMLDivElement}
 */
const paymentForm = document.querySelector('#payment-form');
/**
 * @type {HTMLHeadingElement}
 */
const totalCostElement =  document.querySelector(".card-checkout-card-title")
/**
 * @type {HTMLButtonElement}
 */
const paymentSubmitBtn = document.querySelector("#submit")

if (paymentForm) {
    /**
     * @type {typeof import('@stripe/stripe-js').Stripe}
     */
    let stripe;


    /**
     * @type {typeof import('@stripe/stripe-js').StripeElements}
     */
    let elements;

    initialize();
// checkStatus();

    paymentForm.addEventListener("submit", handleSubmit);

    let emailAddress = '';

// Fetches a payment intent and captures the client secret
    async function initialize() {
        stripe = await loadStripe("pk_test_51KfnFuBpmcrQCF2XMJlSRBdYTUnfGQjqL0PjAGYLutt2WmnFm4KrQsJuW8nQ4StZgG7Nf8I2IYE4haq11nYDr5qY00ouzz7JoO");
        try {
            const response = await fetch("/cart/checkout", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
            })

            try {

                const {clientSecret} = await response.json();
                elements = stripe.elements({clientSecret});

                const linkAuthenticationElement = elements.create("linkAuthentication");
                linkAuthenticationElement.mount("#link-authentication-element");

                const paymentElementOptions = {
                    layout: "tabs",
                };


                const paymentElement = elements.create("payment", paymentElementOptions);
                paymentElement.mount("#payment-element");
                totalCostElement.classList.add("card-checkout-card-title--active")
                paymentSubmitBtn.classList.add("active")

            } catch (e) {
                console.log(e.message);
            }

        } catch (e) {
            console.log(e.message)
        }
    }

    async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);

        const {error} = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: "https://fcf0-112-135-65-171.ap.ngrok.io/cart/checkout/success",
                receipt_email: emailAddress,
            },
        });

        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

        setLoading(false);
    }

// Fetches the payment intent status after payment submission
    async function checkStatus() {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        if (!clientSecret) {
            return;
        }

        const {paymentIntent} = await stripe.retrievePaymentIntent(clientSecret);

        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Payment succeeded!");
                break;
            case "processing":
                showMessage("Your payment is processing.");
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
            default:
                showMessage("Something went wrong.");
                break;
        }
    }

// ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 4000);
    }

// Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#payment-spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#payment-spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }

}

