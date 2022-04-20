<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->render('home.php', [
            'title' => 'Home',
            'message' => 'Welcome main page'
        ]);
    }

    public function notFound()
    {
        $this->render('not-found.php', [
            'title' => 'Not found'
        ]);
    }

}
