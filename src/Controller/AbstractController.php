<?php

namespace App\Controller;


abstract class AbstractController
{
    protected string $templatesDir;

    public function __construct(string $templatesDir)
    {
        $this->templatesDir = $templatesDir;

    }
}
