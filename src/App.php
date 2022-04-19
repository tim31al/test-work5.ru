<?php

namespace App;

use App\Controller\HomeController;
use App\Controller\UserController;
use App\Service\Container;
use App\Service\Interfaces\ContainerInterface;
use App\Service\Session;

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
        $session = $this->container->get(Session::class);
        $session->run();

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        switch ($url) {
            case '/':
                $controller = $this->container->get(HomeController::class);
                $controller->index();
                break;
            case '/register':
                /** @var UserController $controller */
                $controller = $this->container->get(UserController::class);
                $controller->register();
                break;
            case '/login':
                /** @var UserController $controller */
                $controller = $this->container->get(UserController::class);
                $controller->login();
                break;
            case '/logout':
                /** @var UserController $controller */
                $controller = $this->container->get(UserController::class);
                $controller->logout();
                break;
            case '/profile':
                /** @var UserController $controller */
                $controller = $this->container->get(UserController::class);
                $controller->profile();
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                echo '<html><body><h1>Page Not Found</h1></body></html>';
        }

    }


}
