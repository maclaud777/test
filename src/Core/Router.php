<?php

namespace Core;

use Core\Http\Request;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public static function match(Request $request)
    {
        $requestUri = $request->getServer()['REQUEST_URI'];
        foreach (App::getInstance()->config['routes'] as $route) {
            if ($route['path'] == $requestUri) {
                return $route;
            }
        }

        throw new Exception('Error 404', 404);
    }

    /**
     * @param string $route
     * @param array $params
     * @param boolean $absolute
     * @return string
     */
    public static function createUrl($route, array $params = [], $absolute = false)
    {
        return App::getInstance()->config['routes'][$route]['path'];
    }
}