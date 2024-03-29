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
        $this->routes["get"][$path] = $callback;
    }


    public function post(string $path, callable|string|array $callback): void
    {
        $this->routes["post"][$path] = $callback;
    }


    public function resolve(): string
    {
        $path = $this->request->path();  //current path
        $method = $this->request->method(); //current method
        $callback = $this->routes[$method][$path] ?? false;


        // get cookies to check if client_token cookie is set
        if (!$this->request->session->get("is_authenticated")) {
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
        }

        if ($callback === false) {
            $this->response->setStatusCode(code: 404);
            return "Not Found";
        }
        if (is_string($callback)) {
            return $this->response->render($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
            return $callback($this->request, $this->response);

        } else if (is_callable($callback)) {
            return $callback($this->request, $this->response);
        }
        return $callback($this->request, $this->response);
            
    }
}