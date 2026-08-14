<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';
require_once __DIR__ . '/includes/datos.php';

iniciarSesion();

// Si ya hay sesión activa, redirigir al panel
if (hayUsuarioAutenticado()) {
    header('Location: panel.php');
    exit;
}

$errores = [];
$correo = '';
$aviso = '';

// Recuperar correo desde la cookie si existe
if (isset($_COOKIE['correo_recordado'])) {
    $correo = $_COOKIE['correo_recordado'];
}

// Avisos según el parámetro 'estado' en GET
$estado = $_GET['estado'] ?? '';
if ($estado === 'requerido') {
    $aviso = 'Debe iniciar sesión para acceder al panel de administración.';
} elseif ($estado === 'salida') {
    $aviso = 'Su sesión se ha cerrado correctamente.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validar Token CSRF
    if (!tokenCsrfValidado($_POST['csrf_token'] ?? null)) {
        $errores[] = 'La solicitud no es válida o su sesión ha expirado.';
    } else {

        $correo     = trim((string)($_POST['correo'] ?? ''));
        $contrasena = (string)($_POST['contrasena'] ?? '');
        $recordar   = isset($_POST['recordar']);

        if ($correo === '') {
            $errores[] = 'El correo electrónico es obligatorio.';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El formato del correo electrónico no es válido.';
        }

        if ($contrasena === '') {
            $errores[] = 'La contraseña es obligatoria.';
        }

        // 2. Autenticación si los campos básicos están completos
        if (empty($errores)) {
    $usuario = buscarEncargado($correo);
    if ($usuario !== null && password_verify($contrasena, $usuario['hash'])) {
                
                // Regenerar ID de sesión para prevenir Session Fixation
                session_regenerate_id(true);

                // Guardar datos del usuario en sesión
                $_SESSION['usuario'] = [
                    'nombre' => $usuario['nombre'],
                    'correo' => $correo,
                    'rol'    => $usuario['rol'],
                ];

                // Manejo de la Cookie de recordatorio (7 días)
                if ($recordar) {
                    setcookie('correo_recordado', $correo, [
                        'expires'  => time() + (15 * 24 * 60 * 60),
                        'path'     => '/',
                        'httponly' => true,
                        'samesite' => 'Lax'
                    ]);
                } else {
                    // Eliminar cookie si existe
                    if (isset($_COOKIE['correo_recordado'])) {
                        setcookie('correo_recordado', '', [
                            'expires'  => time() - 3600,
                            'path'     => '/',
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]);
                    }
                }

                header('Location: panel.php');
                exit;

            } else {
                // Mensaje genérico de seguridad
                $errores[] = 'Las credenciales ingresadas no son válidas.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Encargado - Sistema de Reservas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="barra">
    <div>
        <strong>Sistema de Reservas UCC</strong>
    </div>
    <nav>
        <a href="index.php">Formulario Público</a>
    </nav>
</header>

<main class="contenedor">
    <h1>Acceso del Encargado</h1>
    <p class="subtitulo">Ingrese sus credenciales para administrar las solicitudes.</p>

    <?php if ($aviso !== ''): ?>
        <div class="aviso"><?php echo e($aviso); ?></div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="login.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo e(tokenCsrf()); ?>">

        <div class="grupo-form">
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" value="<?php echo e($correo); ?>" required>
        </div>

        <div class="grupo-form">
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>
        </div>

        <div class="grupo-form" style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" id="recordar" name="recordar" value="1" <?php echo isset($_COOKIE['correo_recordado']) ? 'checked' : ''; ?>>
            <label for="recordar" style="margin-bottom: 0; font-weight: normal;">Recordar mi correo en este equipo</label>
        </div>

        <button type="submit">Iniciar Sesión</button>
    </form>
</main>

</body>
</html>