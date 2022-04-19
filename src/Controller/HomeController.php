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

}
