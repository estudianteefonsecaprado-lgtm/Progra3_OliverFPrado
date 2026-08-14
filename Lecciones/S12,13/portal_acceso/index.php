<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';
require_once __DIR__ . '/includes/usuarios.php';

iniciarSesion();

if (hayUsuarioAutenticado()) {
    header('Location: panel.php');
    exit;
}

$errores = [];
$correo = '';
$aviso = '';

if (isset($_COOKIE['correo_recordado'])) {
    $correo = $_COOKIE['correo_recordado'];
}

$estado = $_GET['estado'] ?? '';

if ($estado === 'requerido') {
    $aviso = 'Debe iniciar sesión para ver esa página.';
} elseif ($estado === 'salida') {
    $aviso = 'Su sesión se cerró correctamente.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!tokenCsrfValidado($_POST['csrf_token'] ?? null)) {

        $errores[] = 'La solicitud no es válida o expiró. Vuelva a intentarlo.';

    } else {

        $correo = trim((string)($_POST['correo'] ?? ''));
        $contrasena = (string)($_POST['contrasena'] ?? '');

        if ($correo === '') {
            $errores[] = 'El correo electrónico es obligatorio.';
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electrónico no tiene un formato válido.';
        }

        if ($contrasena === '') {
            $errores[] = 'La contraseña es obligatoria.';
        } elseif (strlen($contrasena) < 5) {
            $errores[] = 'La contraseña debe tener al menos 5 caracteres.';
        }

        if (empty($errores)) {

            $usuario = buscarUsuario($correo);

            if (
                $usuario === null ||
                !password_verify($contrasena, $usuario['hash'])
            ) {

                $errores[] = 'Las credenciales no son correctas.';

            } else {

                session_regenerate_id(true);

                $_SESSION['usuario'] = [
                    'correo' => strtolower($correo),
                    'nombre' => $usuario['nombre'],
                    'rol' => $usuario['rol'],
                    'inicio' => date('d/m/Y H:i'),
                ];

                $recordar = isset($_POST['recordar']);

                if ($recordar) {

                    setcookie('correo_recordado', strtolower($correo), [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]);

                } else {

                    setcookie(
                        'correo_recordado',
                        '',
                        [
                            'expires' => time() - 3600,
                            'path' => '/',
                        ]
                    );
                }

                header('Location: panel.php');
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Portal del Club de Programación</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<main class="tarjeta">

    <h1>Club de Programación</h1>

    <p class="subtitulo">
        Acceso para miembros registrados
    </p>

    <?php if ($aviso !== ''): ?>
        <p class="aviso"><?php echo e($aviso); ?></p>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="index.php" method="post" novalidate>

        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo e(tokenCsrf()); ?>">

        <label for="correo">
            Correo institucional
        </label>

        <input
            type="email"
            id="correo"
            name="correo"
            value="<?php echo e($correo); ?>">

        <label for="contrasena">
            Contraseña
        </label>

        <input
            type="password"
            id="contrasena"
            name="contrasena">

        <label class="casilla">

            <input
                type="checkbox"
                name="recordar"
                value="1"
                <?php echo isset($_COOKIE['correo_recordado']) ? 'checked' : ''; ?>>

            Recordar mi correo en este equipo

        </label>

        <button type="submit">
            Ingresar
        </button>

    </form>

</main>

</body>

</html>