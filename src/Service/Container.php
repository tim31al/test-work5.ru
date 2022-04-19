<?php

namespace App\Service;

use App\Service\Interfaces\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services;
    private array $loaded;

    public function load(array $services): void
    {
        $this->loaded = $services;
    }

    public function get(string $name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }

        if (!isset($this->loaded[$name])) {
            throw new \InvalidArgumentException('Service not found');
        }

        if(is_callable($this->loaded[$name])) {
            $this->services[$name] = call_user_func($this->loaded[$name], $this);
        } else {
            $this->services[$name] = $this->loaded[$name];
        }

        return $this->services[$name];
    }
}
