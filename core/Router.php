<?php
/**
 * @package  app\core
 */

namespace app\core;

class Router
{

    protected array $routes = [];
    public Request $request;
    public Response $response;


    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, callable|string|array $callback): void
    {
        // $path = "/"
        // $callback = [HomeController::class, 'getHomePage']
        $this->routes["get"][$path] = $callback;
        // routes = {
        //              "get" :
        //                    {
        //                       "/" : [HomeController::class, 'getHomePage']
        //                    }
        //  }

    }

    public function post(string $path, callable|string|array $callback): void
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve(): string
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;


        // get cookies to check if client_token cookie is set
        $cookies = $this->request->cookies();
        $client_token = isset($cookies["client_token"]) ? $cookies['client_token'] : false;
        if ($client_token) {
            $user = $this->request->session->getPersistentCustomerSession($client_token);
            if (is_int($user)) {
                $this->request->session->set("is_authenticated", true);
                $this->request->session->set("user_id", $user);
                $this->request->session->set("user_role", "customer");
            } else {
                $user = $this->request->session->getPersistentEmployeeSession($client_token);
                if (is_array($user)) {
                    $this->request->session->set("is_authenticated", true);
                    $this->request->session->set("user_id", $user['employee_id']);
                    $this->request->session->set("user_role", $user['role']);
                } else {
                    $this->request->session->set("is_authenticated", false);
                    $this->request->session->set("user_id", null);
                    $this->request->session->set("user_role", null);
                }
            }
        }


        if ($callback === false) {
            return "Not found";
        }
        if (is_string($callback)) {
            return $this->response->render($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return $callback($this->request, $this->response);
    }
}