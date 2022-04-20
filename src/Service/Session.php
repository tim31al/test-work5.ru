<?php

namespace App\Service;

use App\Service\Interfaces\SessionInterface;

class Session implements SessionInterface
{
    public function start()
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
