<?php

namespace core;

use core\Router\RouteContainer;

require "database.php";

class App
{
    public static function Init()
    {
        require '../route/roadmap.php';
        $url = $_SERVER['REQUEST_URI'];
        $type = strtolower($_SERVER['REQUEST_METHOD']);
        RouteContainer::Searcher($url, $type);
    }

}