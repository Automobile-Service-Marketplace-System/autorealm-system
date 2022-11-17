<?php

namespace app\core;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }


    public function get(string $key): mixed
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }
}