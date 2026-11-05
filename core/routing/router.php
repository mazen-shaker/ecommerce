<?php

use Core\Routing\Main;

$routes = Main::$routs;

$undefined = true;




foreach ($routes as $route) {

    if ($_SERVER['REQUEST_METHOD'] !== $route['method']) {
        continue;
    }

    $parameterValue = null;

    if ($route['parameter']) {

        $pattern = preg_replace('/\{.*?\}/', '([^/]+)', $route['url']);

        if (!preg_match('#^' . $pattern . '$#', $requestUrl, $matches)) {
            continue;
        }

        $parameterValue = $matches[1];

    } else {

        if ($requestUrl !== $route['url']) {
            continue;
        }
    }

    $controllerClass = 'App\\Http\\Controllers\\' . $route['controller'][0];

    $controller = new $controllerClass();

    $method = $route['controller'][1];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($route['valedation']) {

            $valedationClass = $route['valedation'];
            $valedation = new $valedationClass();

            if (!$valedation->handle()) {
                $undefined = false;
                break;
            }
        }

        $controller->$method($_POST);

    } else {

        if ($route['parameter']) {
            print_r($controller->$method($parameterValue));
        } else {
            print_r($controller->$method());
        }
    }

    $undefined = false;
    break;
}

if ($undefined) {
    return "error";
}
