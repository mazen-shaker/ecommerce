<?php

namespace core\view;

class Main
{

function view(string $name, $data = null): string {
       
    $path = "./resources/views/{$name}.php";

    extract($data);

    ob_start();
    require $path;

    return ob_get_clean(); 
}

}
