<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';
require_once __DIR__ . '/includes/datos.php';
require_once __DIR__ . '/includes/funciones.php';

iniciarSesion();
exigirSesion();

$usuario = $_SESSION['usuario'];

// 1. Filtros por GET
$texto        = trim((string)($_GET['q'] ?? ''));
$estadoFiltro = (string)($_GET['estado'] ?? '');
$labFiltro    = (string)($_GET['laboratorio'] ?? '');

$estadosValidos = ['pendiente', 'aprobada', 'rechazada'];
$laboratoriosValidos = ['Lab 1 - Cómputo General', 'Lab 2 - Redes y Telecomunicaciones', 'Lab 3 - Inteligencia Artificial', 'Lab 4 - Desarrollo de Software'];
if (!in_array($estadoFiltro, $estadosValidos, true)) {
    $estadoFiltro = '';
}

if (!in_array($labFiltro, $laboratoriosValidos, true)) {
    $labFiltro = '';
}

$mensajeAccion = '';

// 2. Procesar cambio de estado vía POST (AQUÍ VAN TODAS LAS LLAVES)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? null;

    if (!tokenCsrfValidado($token)) {
        $mensajeAccion = 'Error de seguridad: Solicitud CSRF no válida.';
    } else {
        $idSolicitud = (string)($_POST['id_solicitud'] ?? '');
        $nuevoEstado = (string)($_POST['nuevo_estado'] ?? '');

        if ($idSolicitud !== '' && in_array($nuevoEstado, $estadosValidos, true)) {
            if (actualizarEstadoSolicitud($idSolicitud, $nuevoEstado)) {
                $mensajeAccion = 'El estado de la solicitud #' . $idSolicitud . ' se actualizó a "' . $nuevoEstado . '".';
            } else {
                $mensajeAccion = 'No se encontró la solicitud especificada.';
            }
        }
    }
}
// 3. Obtener solicitudes para renderizar
$todasLasSolicitudes  = obtenerSolicitudes();
$solicitudesFiltradas = filtrarSolicitudes($todasLasSolicitudes, $texto, $estadoFiltro, $labFiltro);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Reservas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="barra">
    <div>
        <strong><?php echo e($usuario['nombre']); ?></strong>
        <span class="rol">(<?php echo e($usuario['rol']); ?>)</span>
    </div>
    <nav>
        <a href="salir.php" class="salir">Cerrar sesión</a>
    </nav>
</header>

<main class="contenedor-ancho">
    <h1>Panel de Gestión de Reservas</h1>
    <p class="subtitulo">Administre las solicitudes de laboratorio recibidas.</p>

    <?php if ($mensajeAccion !== ''): ?>
        <div class="aviso"><?php echo e($mensajeAccion); ?></div>
    <?php endif; ?>

    <form action="panel.php" method="get" class="form-busqueda">
        <div class="grupo-busqueda">
            <label for="q">Buscar por texto</label>
            <input type="text" id="q" name="q" placeholder="Nombre o carné..." value="<?php echo e($texto); ?>">
        </div>

        <div class="grupo-busqueda">
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="">Todos los estados</option>
                <?php foreach ($estadosValidos as $opcEstado): ?>
                    <option value="<?php echo e($opcEstado); ?>" <?php echo $opcEstado === $estadoFiltro ? 'selected' : ''; ?>>
                        <?php echo e($opcEstado); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grupo-busqueda">
            <label for="laboratorio">Laboratorio</label>
            <select id="laboratorio" name="laboratorio">
                <option value="">Todos los laboratorios</option>
                <?php foreach ($laboratoriosValidos as $opcLab): ?>
                    <option value="<?php echo e($opcLab); ?>" <?php echo $opcLab === $labFiltro ? 'selected' : ''; ?>>
                        <?php echo e($opcLab); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grupo-busqueda-boton">
            <button type="submit">Filtrar</button>
            <a href="panel.php" class="boton-limpiar">Limpiar</a>
        </div>
    </form>

    <p class="resumen">
        Mostrando <strong><?php echo count($solicitudesFiltradas); ?></strong> de <strong><?php echo count($todasLasSolicitudes); ?></strong> solicitudes encontradas.
    </p>

    <?php if (empty($solicitudesFiltradas)): ?>
        <p class="mensaje-vacio">No se encontraron solicitudes que coincidan con los criterios de búsqueda.</p>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Laboratorio</th>
                        <th>Fecha y Horario</th>
                        <th>Asistentes</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($solicitudesFiltradas as $sol): ?>
                        <tr>
                            <td>#<?php echo e((string)$sol['id']); ?></td>
                            <td>
                                <strong><?php echo e($sol['nombre']); ?></strong><br>
                                <small><?php echo e($sol['correo']); ?></small>
                            </td>
                            <td><?php echo e($sol['laboratorio']); ?></td>
                            <td>
                                <?php echo e($sol['fecha']); ?><br>
                                <?php echo e($sol['hora']); ?>
                            </td>
                            <?php echo e((string)$sol['equipos']); ?>
                            <td><?php echo e($sol['motivo']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e(strtolower($sol['estado'])); ?>">
                                    <?php echo e($sol['estado']); ?>

                                </span>
                            </td>
                            <td>
                                <form action="panel.php" method="post" style="display:inline-block;">
                                    <input type="hidden" name="csrf_token" value="<?php echo e(tokenCsrf()); ?>">
                                    <input type="hidden" name="id_solicitud" value="<?php echo e((string)$sol['id']); ?>">
                                    
                                    <?php if ($sol['estado'] !== 'aprobada'): ?>
                                        <button type="submit" name="nuevo_estado" value="aprobada" class="btn-accion btn-aprobar">Aprobar</button>
                                    <?php endif; ?>
                                    
                                    <?php if ($sol['estado'] !== 'rechazada'): ?>
                                        <button type="submit" name="nuevo_estado" value="rechazada" class="btn-accion btn-rechazar">Rechazar</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

</body>
</html>