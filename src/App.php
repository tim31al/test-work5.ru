<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\SecurityController;
use App\Controller\UserController;
use App\Service\Container;
use App\Service\Interfaces\ContainerInterface;
use App\Service\Interfaces\SessionInterface;


class App
{
    private ContainerInterface $container;

    public function __construct()
    {
        $container = new Container();
        $settings = require __DIR__ . '/../config/settings.php';
        $services = require __DIR__ . '/../config/services.php';
        $container->load(array_merge($settings, $services));

        $this->container = $container;
    }

    public function run()
    {
        $session = $this->container->get(SessionInterface::class);
        $session->start();

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($url) {
            case '/':
                $controller = $this->container->get(HomeController::class);
                $controller->index();
                break;
            case '/register':
                $controller = $this->container->get(SecurityController::class);
                $controller->register();
                break;
            case '/login':
                $controller = $this->container->get(SecurityController::class);
                $controller->login();
                break;
            case '/logout':
                $controller = $this->container->get(SecurityController::class);
                $controller->logout();
                break;
            case '/profile':
                /** @var UserController $controller */
                $controller = $this->container->get(UserController::class);
                $controller->profile();
                break;
            default:
                $controller = $this->container->get(HomeController::class);
                $controller->notFound();
                break;
        }

    }


}
