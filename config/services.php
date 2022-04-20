<?php

use App\Controller\HomeController;
use App\Controller\SecurityController;
use App\Controller\UserController;
use App\Model\User;
use App\Service\Interfaces\ContainerInterface;
use App\Service\Interfaces\SessionInterface;
use App\Service\Session;
use App\Utils\UserValidator;


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
        $validator = new UserValidator();

        return new User($pdo, $validator);
    },

    SessionInterface::class => function (): SessionInterface {
        return new Session();
    },

    HomeController::class => function (ContainerInterface $container): HomeController {
        return new HomeController($container);
    },

    SecurityController::class => function (ContainerInterface $container): SecurityController {
        return new SecurityController($container);
    },

    UserController::class => function (ContainerInterface $container): UserController {
        return new UserController($container);
    },
];
