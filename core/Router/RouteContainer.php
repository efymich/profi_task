<?php


namespace core\Router;


class RouteContainer
{
    public static array $routes = [];

    public static function Add(Router $route, string $type): void
    {
        self::$routes[$type][] = $route;
    }

    public static function Searcher(string $url, array $data = [])
    {
        /**
         * @var $router Router
         */
        $type = strtolower($_SERVER['REQUEST_METHOD']);
        foreach (self::$routes[$type] as $router) {
            if (!$router->Check($url)) {
                continue;
            }
            return $router->Apply($data);
        }
        die('Check failed!');
    }
}