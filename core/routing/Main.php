<?php

namespace Core\Routing;

class Main
{
    static array $routs = [];

    static function post(string $url, array $controller, $valedation = null)
    {
        self::$routs[] = [
            'url' => $url,
            'controller' => $controller,
            'method' => 'POST',
            'parameter' => false,
            'valedation' => $valedation
        ];
    }


    static function get(string $url, array $controller)
    {
        

        $parameter = false;

        if (preg_match('/\{(.*?)\}/', $url, $matches)) {
            $parameter = $matches[1];
        }

        self::$routs[] = [
            'url' => $url,
            'controller' => $controller,
            'method' => 'GET',
            'parameter' => $parameter
        ];
    }
}
