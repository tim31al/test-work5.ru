<?php

use App\Model\User;
use App\Service\Container;

require_once __DIR__.'/../src/autoload.php';

$container = new Container();
$settings = require __DIR__ . '/../config/settings.php';
$services = require __DIR__ . '/../config/services.php';
$container->load(array_merge($settings, $services));

/** @var \App\Model\User $model */
$model = $container->get(User::class);
$model->init();
