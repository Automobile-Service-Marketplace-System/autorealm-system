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

    public function get(string $path, callable |string|array $callback): void
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

    public function post(string $path, callable |string|array $callback): void
    {
        $this->routes["post"][$path] = $callback;
    }

    public function resolve(): string
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

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