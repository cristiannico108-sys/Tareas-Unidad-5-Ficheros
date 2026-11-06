<?php


spl_autoload_register(function (string $nombreClase): void {
    
    $rutaFichero = dirname(__DIR__) . '/src/' 
                 . str_replace('\\', DIRECTORY_SEPARATOR, $nombreClase) 
                 . '.php';

    if (file_exists($rutaFichero)) {
        require_once $rutaFichero;
    }
});