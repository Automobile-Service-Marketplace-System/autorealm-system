<?php

/**
 * @package app\core
 */

namespace app\core;
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static string $rootDir;

    public function __construct(string $rootDir)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router(request: $this->request, response: $this->response);
        self::$rootDir = $rootDir;
    }


    public function run(): void
    {
        echo $this->router->resolve();
    }

}