<?php

/**
 * Gestor de carga automática para clases y componentes del sistema.
 * Se ejecuta de forma dinámica al instanciar dependencias no declaradas.
 */
spl_autoload_register(function (string $nombreEntidad): void {
    $baseDirectorio = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    $ficheroClase = $baseDirectorio . str_replace('\\', DIRECTORY_SEPARATOR, $nombreEntidad) . '.php';

    if (file_exists($ficheroClase)) {
        include_once $ficheroClase;
    }
});