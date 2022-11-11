<?php

namespace app\core;

/**
 * Class Response
 * @package app\core
 */
class Response
{

    /**
     * Use this method to set the response status code
     * @param int $code
     * @return void
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }


    /**
     * Set response headers
     * @param string $key - Key value of the header
     * @param string $value - Value of the header
     * @return void
     */
    public function setHeader(string $key, string $value): void
    {
        header("$key: $value");
    }

    /**
     * Use this method to redirect to another page
     * @param string $path - Internal or external path to redirect to
     * @param bool $replace - Whether to replace the previously set redirect location
     * @param int $statusCode - Status code that should be set
     * @return void
     */
    public function redirect(string $path, bool $replace = true, int $statusCode = 302): void
    {
        header("Location: $path", $replace, $statusCode);
    }


    /**
     * Use this method to render a view that resides in the view folder
     * @param string $view - file name of the view
     * @param string $layout - layout that should be used
     * @param array $pageParams
     * @param array $layoutParams
     * @return string
     */
    public function render(string $view, string $layout = "main", array $pageParams = [], array $layoutParams = []): string
    {
        $layoutContent = $this->getLayout($layout, $layoutParams);
        $viewContent = $this->getView($view, $pageParams);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Use this method to send data as a JSON value
     * @param mixed $data - Data that needs to be sent
     * @return string
     */
    public function json(mixed $data): string
    {
        $this->setHeader(key: "Content-Type", value: "application/json");
        $this->setHeader(key: "charset", value: "utf-8");
        return json_encode($data);
    }

    private function getLayout(string $layout = "main", array $params = []): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$rootDir . "/layouts/$layout.php";
        return ob_get_clean();
    }


    private function getView(string $view, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$rootDir . "/views/$view.php";
        return ob_get_clean();
    }


}