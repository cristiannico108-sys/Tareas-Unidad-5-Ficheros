<?php

/**
 * Cargador automático de clases para la arquitectura del proyecto.
 */
spl_autoload_register(static function (string $spec): void {
    $pathParts = [
        __DIR__,
        'src',
        str_replace('\\', DIRECTORY_SEPARATOR, $spec) . '.php'
    ];
    
    $targetFile = implode(DIRECTORY_SEPARATOR, $pathParts);
    
    if (file_exists($targetFile)) {
        require($targetFile);
    }
});