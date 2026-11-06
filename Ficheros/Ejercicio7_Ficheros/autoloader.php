<?php

/**
 * Registro de autocarga de componentes del sistema.
 */
spl_autoload_register(function (string $identificadorClase): void {
    $directorioRaiz = __DIR__ . '/src/';
    $rutaCompleta = $directorioRaiz . str_replace('\\', '/', $identificadorClase) . '.php';

    if (file_exists($rutaCompleta)) {
        include_once $rutaCompleta;
    }
});