<?php

namespace App\Service\Interfaces;

interface SessionInterface
{
    public function start();

    public function set(string $key, string $value): void;

    public function remove(string $key): void;

    public function get(string $key): ?string;

}
