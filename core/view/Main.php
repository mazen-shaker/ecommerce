<?php

namespace core\view;

class Main
{

<<<<<<< HEAD
function view(string $name,$data = null): string {
       
    $path = "./resources/views/{$name}.php";
    
    $data != null ? extract($data) : $data;
=======
    function view(string $name, $data = null): string
    {
        $path = "./resources/views/{$name}.php";

        $data = $data ?? null;
>>>>>>> main

        ob_start();
        extract($data ?? []);
        require $path;

        return ob_get_clean();
    }
}
