<?php

spl_autoload_register(function ($class_name) {
    $path = substr($class_name, 4, );
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    $class = __DIR__.DIRECTORY_SEPARATOR.$path.'.php';

    if (file_exists($class)) {
        include $class;
    }

});
