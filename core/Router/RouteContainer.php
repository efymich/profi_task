<?php


namespace core\Router;


class RouteContainer
{
    private static array $routes = [];

    public static function Add(Router $route, string $type): void
    {
        self::$routes[$type][] = $route;
    }

    public static function Searcher(string $url, string $type, array $data = [])
    {
        /**
         * @var $router Router
         */
        foreach (self::$routes[$type] as $router) {
            if (!$router->Check($url)) {
                continue;
            }
            return $router->Apply($data);
        }
        die('Check failed!');
    }
}