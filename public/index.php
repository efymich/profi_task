<?php

use core\App;

spl_autoload_register(function ($class) {
    $class = str_replace("\\", '/', $class);
    include '../' . $class . '.php';
});

App::Init();