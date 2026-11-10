<?php

namespace core\view;

class Main
{

    function view(string $name, $data = null): string
    {
        $path = "./resources/views/{$name}.php";

        $data = $data ?? null;

        ob_start();
        extract($data ?? []);
        require $path;

        return ob_get_clean();
    }
}
