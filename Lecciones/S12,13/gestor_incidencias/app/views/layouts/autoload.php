<?php

declare(strict_types=1);

spl_autoload_register(static function (string $clase): void {
    $prefijo = 'App\\';
    $directorioBase = __DIR__ . DIRECTORY_SEPARATOR;
    $longitud = strlen($prefijo);

    if (strncmp($prefijo, $clase, $longitud) !== 0) {
        return;
    }

    $nombreRelativo = substr($clase, $longitud);

    $archivo = $directorioBase .
        str_replace('\\',
            DIRECTORY_SEPARATOR, $nombreRelativo)
        . '.php';

    if (is_file($archivo)) {
        require $archivo;
    }
});