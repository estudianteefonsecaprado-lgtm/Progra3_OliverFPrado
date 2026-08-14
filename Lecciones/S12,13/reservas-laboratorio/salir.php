<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';

iniciarSesion();

// Limpiar arreglo de sesión
$_SESSION = [];

// Expirar la cookie de sesión si existe
if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires'  => time() - 42000,
        'path'     => $parametros['path'],
        'domain'   => $parametros['domain'],
        'secure'   => $parametros['secure'],
        'httponly' => $parametros['httponly'],
        'samesite' => $parametros['samesite'] ?? 'Lax'
    ]);
}

// Destruir la sesión
session_destroy();

// Redirigir al login informando el estado
header('Location: login.php?estado=salida');
exit;