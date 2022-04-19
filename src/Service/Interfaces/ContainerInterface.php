<?php

namespace App\Service\Interfaces;

interface ContainerInterface
{
    public function load(array $services): void;
    public function get(string $name);
}
