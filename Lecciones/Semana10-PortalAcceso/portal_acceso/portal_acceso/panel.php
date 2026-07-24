<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/seguridad.php';
require_once __DIR__ . '/includes/miembros.php';

iniciarSesion();
exigirSesion();

$usuario = $_SESSION['usuario'];

$texto = trim((string)($_GET['q'] ?? ''));
$area = (string)($_GET['area'] ?? '');

$areasValidas = ['Frontend', 'Backend', 'Datos'];

if (!in_array($area, $areasValidas, true)) {
    $area = '';
}

$resultados = filtrarMiembros($miembros, $texto, $area);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de miembros</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

<header class="barra">

    <div>
        <strong><?php echo e($usuario['nombre']); ?></strong>
        <span class="rol"><?php echo e($usuario['rol']); ?></span>
    </div>

    <a class="salir" href="salir.php">
        Cerrar sesión
    </a>

</header>

<main class="contenido">

    <h1>Directorio del club</h1>

    <p class="subtitulo">
        Sesión iniciada el
        <?php echo e($usuario['inicio']); ?>.
    </p>

    <form action="panel.php" method="get" class="buscador">

        <label for="q">Buscar por nombre</label>

        <input
            type="text"
            id="q"
            name="q"
            value="<?php echo e($texto); ?>">

        <label for="area">Área</label>

        <select id="area" name="area">

            <option value="">Todas</option>

            <?php foreach ($areasValidas as $opcion): ?>

                <option
                    value="<?php echo e($opcion); ?>"
                    <?php echo $opcion === $area ? 'selected' : ''; ?>>

                    <?php echo e($opcion); ?>

                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit">
            Filtrar
        </button>

    </form>

    <p class="resumen">
        <?php echo count($resultados); ?>
        de
        <?php echo count($miembros); ?>
        miembros coinciden con la búsqueda.
    </p>

    <table>

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Área</th>
                <th>Nivel</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($resultados as $miembro): ?>

                <tr>

                    <td><?php echo e($miembro['nombre']); ?></td>

                    <td><?php echo e($miembro['area']); ?></td>

                    <td><?php echo e($miembro['nivel']); ?></td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</main>

</body>
</html>