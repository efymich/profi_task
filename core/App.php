<?php

namespace core;

use core\Response\JsonResponse;
use core\Router\RouteContainer;

require "database.php";

class App
{
    public static function Init()
    {
        /**
         * @var $response_obj JsonResponse
         */
        require '../route/roadmap.php';
        $url = $_SERVER['REQUEST_URI'];
        $type = strtolower($_SERVER['REQUEST_METHOD']);
        $response_obj = RouteContainer::Searcher($url, $type);
        $response_obj->formHeader();
        echo $response_obj->formBody();
    }

}