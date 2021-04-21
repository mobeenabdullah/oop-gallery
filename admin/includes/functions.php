<?php

function classAutoLoader($class) {
    $class = strtolower($class);
    $path = "includes/{$class}.php";

    if(file_exists($path)) {
        require_once($path);
    } else {
        die("This file named {$class}.php was not found");
    }
}
spl_autoload_register('classAutoLoader');