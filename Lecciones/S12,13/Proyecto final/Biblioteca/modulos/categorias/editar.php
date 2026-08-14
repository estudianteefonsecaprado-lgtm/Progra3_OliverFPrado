<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: editar.php
 * Descripción:
 * Permite editar una categoría existente.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

require_once("../../includes/conexion.php");
require_once("../../includes/funciones.php");
require_once("../../includes/sesion.php");

// ============================================================
// Verificar sesión
// ============================================================

protegerPagina();

// ============================================================
// Verificar permisos de administrador
// ============================================================

if ($_SESSION["rol"] != "Administrador") {

    redireccionar("../../inicio.php");

}

// ============================================================
// Obtener el ID de la categoría
// ============================================================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;


// ============================================================
// Actualizar categoría
// ============================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int) $_POST["id"];
    $nombre = limpiarTexto($_POST["nombre"]);
    $descripcion = limpiarTexto($_POST["descripcion"]);

    $sql = "UPDATE categorias
            SET nombre = ?, descripcion = ?
            WHERE id_categoria = ?";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param(
        "ssi",
        $nombre,
        $descripcion,
        $id
    );

    if ($consulta->execute()) {

        redireccionar("listar.php");

    } else {

        $mensaje = "No fue posible actualizar la categoría.";

    }

}


// ============================================================
// Consultar la información de la categoría
// ============================================================

$sql = "SELECT * FROM categorias
        WHERE id_categoria = ?";

$consulta = $conexion->prepare($sql);

$consulta->bind_param("i", $id);

$consulta->execute();

$resultado = $consulta->get_result();

$categoria = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ======================================================
         Configuración del documento
    ======================================================= -->

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar categoría</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Hoja de estilos personalizada -->

    <link rel="stylesheet" href="../../css/estilos.css">

</head>

<body>

<!-- ==========================================================
     Contenedor principal
=========================================================== -->

<div class="container mt-5">

    <!-- Tarjeta del formulario -->

    <div class="card shadow">

        <!-- Encabezado -->

        <div class="card-header card-header-personalizado">

            <h3>

                Editar categoría

            </h3>

        </div>

        <div class="card-body">

            <!-- Mostrar mensaje de error si ocurre alguno -->

            <?php if (isset($mensaje)) { ?>

                <div class="alert alert-danger">

                    <?= $mensaje; ?>

                </div>

            <?php } ?>

            <!-- Formulario para editar la categoría -->

            <form method="POST">

                <!-- Identificador oculto de la categoría -->

                <input
                    type="hidden"
                    name="id"
                    value="<?= $categoria["id_categoria"]; ?>">

                <!-- Campo: Nombre -->

                <div class="mb-3">

                    <label class="form-label">

                        Nombre

                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="<?= $categoria["nombre"]; ?>"
                        required>

                </div>

                <!-- Campo: Descripción -->

                <div class="mb-3">

                    <label class="form-label">

                        Descripción

                    </label>

                    <textarea
                        name="descripcion"
                        class="form-control"
                        rows="3"
                        required><?= $categoria["descripcion"]; ?></textarea>

                </div>

                <!-- Botones de acción -->

                <button
                    type="submit"
                    class="btn btn-warning">

                    Actualizar

                </button>

                <a
                    href="listar.php"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript del proyecto -->

<script src="../../js/script.js"></script>

</body>

</html>

<?php

// ============================================================
// Cerrar conexión con la base de datos
// ============================================================

$conexion->close();

?>