<?php

use App\Controller\HomeController;
use App\Controller\UserController;
use App\Model\User;
use App\Service\Interfaces\ContainerInterface;
use App\Service\Session;


return [
    PDO::class => function (ContainerInterface $container): PDO {
        $db = $container->get('db');
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            $db['driver'],
            $db['host'],
            $db['port'],
            $db['dbname']
        );

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, $db['user'], $db['password'], $opt);
    },

    User::class => function (ContainerInterface $container): User {
        $pdo = $container->get(PDO::class);

        return new User($pdo);
    },

    Session::class => function(): Session {
        return new Session();
    },

    HomeController::class => function (ContainerInterface $container): HomeController {
        $templatesDir = $container->get('templates_dir');

        return new HomeController($templatesDir);
    },

    UserController::class => function (ContainerInterface $container): UserController {
        $templatesDir = $container->get('templates_dir');
        $model = $container->get(User::class);
        $session = $container->get(Session::class);

        return new UserController($templatesDir, $model, $session);
    },


];
