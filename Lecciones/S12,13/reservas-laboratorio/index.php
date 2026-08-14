<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';
require_once __DIR__ . '/includes/datos.php';
require_once __DIR__ . '/includes/funciones.php';

iniciarSesion();

$errores = [];
$mensajeExito = '';

// Variables para repoblado del formulario
$nombre = '';
$correo = '';
$carne = '';
$laboratorio = '';
$fecha = '';
$hora = '';
$equipos = '1';
$motivo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Validar Token CSRF
    if (!tokenCsrfValidado($_POST['csrf_token'] ?? null)) {
        $errores[] = 'La solicitud no es válida o su sesión ha expirado. Intente nuevamente.';
    } else {

        // Capturar y sanitizar entradas
        $nombre      = trim((string)($_POST['nombre'] ?? ''));
        $correo      = trim((string)($_POST['correo'] ?? ''));
        $carne       = trim((string)($_POST['carne'] ?? ''));
        $laboratorio = trim((string)($_POST['laboratorio'] ?? ''));
        $fecha       = trim((string)($_POST['fecha'] ?? ''));
        $hora        = trim((string)($_POST['hora'] ?? ''));
        $equiposRaw  = trim((string)($_POST['equipos'] ?? '1'));
        $motivo      = trim((string)($_POST['motivo'] ?? ''));

        // 2. Validaciones de Servidor

        if ($nombre === '' || strlen($nombre) < 3) {
            $errores[] = 'Debe ingresar un nombre completo válido (mínimo 3 caracteres).';
        }

        if ($correo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'Debe proporcionar un correo electrónico válido.';
        }

        if ($carne === '') {
            $errores[] = 'El número de carné es obligatorio.';
        }

        if (!in_array($laboratorio, $laboratoriosValidos, true)) {
            $errores[] = 'El laboratorio seleccionado no pertenece a la lista autorizada.';
        }

        if ($fecha === '') {
            $errores[] = 'Debe indicar la fecha de la reserva.';
        } else {
            $hoy = date('Y-m-d');
            if ($fecha < $hoy) {
                $errores[] = 'La fecha de reserva no puede ser en el pasado.';
            }
        }

        if ($hora === '') {
            $errores[] = 'Debe indicar la hora de inicio de la reserva.';
        }

        if (!ctype_digit($equiposRaw)) {
            $errores[] = 'La cantidad de equipos debe ser un número entero.';
        } else {
            $numEquipos = (int)$equiposRaw;
            if ($numEquipos < 1 || $numEquipos > 40) {
                $errores[] = 'La cantidad de equipos debe estar entre 1 y 40.';
            }
        }

        if ($motivo === '' || strlen($motivo) < 10) {
            $errores[] = 'Debe detallar el motivo de la reserva (mínimo 10 caracteres).';
        }

        // 3. Procesamiento si no hay errores
        if (empty($errores)) {
            agregarSolicitud([
                'nombre'      => $nombre,
                'correo'      => $correo,
                'carne'       => $carne,
                'laboratorio' => $laboratorio,
                'fecha'       => $fecha,
                'hora'        => $hora,
                'equipos'     => (int)$equiposRaw,
                'motivo'      => $motivo
            ]);

            $mensajeExito = '¡Su solicitud de reserva ha sido enviada correctamente y está en estado PENDIENTE!';

            // Limpiar campos tras guardar con éxito
            $nombre = $correo = $carne = $laboratorio = $fecha = $hora = $motivo = '';
            $equipos = '1';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Laboratorio de Cómputo</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="barra">
    <div>
        <strong>Sistema de Reservas UCC</strong>
    </div>
    <nav>
        <a href="login.php">Acceso Encargado</a>
    </nav>
</header>

<main class="contenedor">
    <h1>Solicitud de Laboratorio</h1>
    <p class="subtitulo">Complete el formulario para solicitar la reserva de un laboratorio de cómputo.</p>

    <?php if ($mensajeExito !== ''): ?>
        <div class="exito"><?php echo e($mensajeExito); ?></div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="index.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo e(tokenCsrf()); ?>">

        <div class="grupo-form">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo e($nombre); ?>" required>
        </div>

        <div class="mismo-renglon">
            <div class="grupo-form">
                <label for="correo">Correo institucional</label>
                <input type="email" id="correo" name="correo" value="<?php echo e($correo); ?>" placeholder="ejemplo@est.castrocarazo.ac.cr" required>
            </div>
            <div class="grupo-form">
                <label for="carne">Carné / Identificación</label>
                <input type="text" id="carne" name="carne" value="<?php echo e($carne); ?>" required>
            </div>
        </div>

        <div class="grupo-form">
            <label for="laboratorio">Laboratorio requerido</label>
            <select id="laboratorio" name="laboratorio" required>
                <option value="">-- Seleccione un laboratorio --</option>
                <?php foreach ($laboratoriosValidos as $lab): ?>
                    <option value="<?php echo e($lab); ?>" <?php echo ($laboratorio === $lab) ? 'selected' : ''; ?>>
                        <?php echo e($lab); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mismo-renglon">
            <div class="grupo-form">
                <label for="fecha">Fecha requerida</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo e($fecha); ?>" required>
            </div>
            <div class="grupo-form">
                <label for="hora">Hora de inicio</label>
                <input type="time" id="hora" name="hora" value="<?php echo e($hora); ?>" required>
            </div>
            <div class="grupo-form">
                <label for="equipos">N° Equipos</label>
                <input type="number" id="equipos" name="equipos" min="1" max="40" value="<?php echo e($equipos); ?>" required>
            </div>
        </div>

        <div class="grupo-form">
            <label for="motivo">Motivo / Justificación del uso</label>
            <textarea id="motivo" name="motivo" rows="3" required><?php echo e($motivo); ?></textarea>
        </div>

        <button type="submit">Enviar Solicitud</button>
    </form>
</main>

</body>
</html>