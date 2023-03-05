<?php

namespace app\core;

/**
 * @package app\core
 */
class Request
{

    public Session $session;


    public function __construct()
    {
        $this->session = new Session();
    }


    /**
     * Get the path of current request without any url parameters.
     * @return string
     */
    public function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? "/";
        $position = strpos($path, "?");
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    /**
     * Get the method of the current request
     * @return string
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    public function query(): array
    {
        $query = [];
        foreach ($_GET as $key => $value) {
            $query[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $query;
    }
    public function body(): array
    {
        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // also should check for json body
        if (empty($body)) {
            try {
                $body = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                $body = [];
            }
        }
        return $body;
    }

    public function cookies() : array
    {
        $cookies = [];
        foreach ($_COOKIE as $key => $value) {
            $cookies[$key] = filter_input(INPUT_COOKIE, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $cookies;
    }
}