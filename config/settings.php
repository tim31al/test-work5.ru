<?php

return [
    'db' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ],
    'app_name' => 'Test app',
    'templates_dir' => __DIR__.'/../templates/',
];
