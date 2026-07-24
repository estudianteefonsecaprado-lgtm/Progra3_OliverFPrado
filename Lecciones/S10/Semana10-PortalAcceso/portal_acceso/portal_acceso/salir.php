<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';

iniciarSesion();

$_SESSION = [];

if (ini_get('session.use_cookies')) {

    $parametros = session_get_cookie_params();

    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $parametros['path'],
        'domain' => $parametros['domain'],
        'secure' => $parametros['secure'],
        'httponly' => $parametros['httponly'],
    ]);
}

session_destroy();

header('Location: index.php?estado=salida');
exit;