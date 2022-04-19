<?php

namespace App\Service;

class Session
{
    public function run()
    {
        session_start();
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void
    {
        if ($this->get($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

}
