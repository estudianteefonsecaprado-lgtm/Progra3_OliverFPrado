<?php
declare(strict_types=1);

// Inicia la sesión una sola vez de forma segura
function iniciarSesion(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Genera un token CSRF único para el formulario
function tokenCsrf(): string {
    iniciarSesion();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Compara el token enviado en POST con el guardado en la sesión
function tokenCsrfValidado(?string $tokenRecibido): bool {
    iniciarSesion();
    if (empty($_SESSION['csrf_token']) || $tokenRecibido === null || $tokenRecibido === '') {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $tokenRecibido);
}

// Escapa código HTML para prevenir ataques XSS
function e(?string $texto): string {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

// Comprueba si hay un encargado autenticado
function hayUsuarioAutenticado(): bool {
    iniciarSesion();
    return isset($_SESSION['usuario']);
}

// Protege una página privada: si no hay sesión activa, redirige al login
function exigirSesion(): void {
    if (!hayUsuarioAutenticado()) {
        header('Location: login.php?estado=requerido');
        exit;
    }
}