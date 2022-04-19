<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $title = 'Home';
        $message = 'Welcome Home';

        include $this->templatesDir.'home.php';
    }

    public function notFound()
    {
        $title = 'Not found';
        include $this->templatesDir.'not-found.php';
    }

}
