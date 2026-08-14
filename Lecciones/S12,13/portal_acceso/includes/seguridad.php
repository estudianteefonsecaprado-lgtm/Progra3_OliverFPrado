<?php

// Inicia la sesión una sola vez, sin importar cuantas veces se invoque
function iniciarSesion(): void{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
}

// Token CSRF de la sesión actual

function tokenCsrf(): string{
    iniciarSesion();
    if(empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

//Comparar el token recibido con el token guardado en la sesión
function tokenCsrfValidado(?string $tokenRecibido): bool{

    iniciarSesion();
    if(empty($_SESSION['csrf_token']) || $tokenRecibido === null || $tokenRecibido === ''){
        return false;
    }
    return hash_equals($_SESSION['csrf_token'] , $tokenRecibido);
}

function e(?string $texto) : string{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function hayUsuarioAutenticado(): bool{
    iniciarSesion();
    return isset($_SESSION['usuario']);
}
// Proteger una pagina: si no hay sesión, redirige al formulario de acceso
function exigirSesion():void{
    if(!hayUsuarioAutenticado()){
        header('Location: index.php?estado=requerido');
        exit;
    }
}
?>
