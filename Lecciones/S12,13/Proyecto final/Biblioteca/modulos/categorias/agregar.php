<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: agregar.php
 * Descripción:
 * Permite registrar una nueva categoría.
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
// Guardar categoría
// ============================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = limpiarTexto($_POST["nombre"]);
    $descripcion = limpiarTexto($_POST["descripcion"]);

    $sql = "INSERT INTO categorias (nombre, descripcion)
            VALUES (?, ?)";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param(
        "ss",
        $nombre,
        $descripcion
    );

    if ($consulta->execute()) {

        redireccionar("listar.php");

    } else {

        $mensaje = "No fue posible guardar la categoría.";

    }

}

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

    <title>Agregar categoría</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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

                Agregar categoría

            </h3>

        </div>

        <div class="card-body">

            <!-- Mostrar mensaje de error si ocurre alguno -->

            <?php if (isset($mensaje)) { ?>

                <div class="alert alert-danger">

                    <?= $mensaje; ?>

                </div>

            <?php } ?>

            <!-- Formulario para registrar una categoría -->

            <form method="POST">

                <!-- Campo: Nombre -->

                <div class="mb-3">

                    <label
                        for="nombre"
                        class="form-label">

                        Nombre

                    </label>

                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        required>

                </div>

                <!-- Campo: Descripción -->

                <div class="mb-3">

                    <label
                        for="descripcion"
                        class="form-label">

                        Descripción

                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        rows="3"
                        required></textarea>

                </div>

                <!-- Botones de acción -->

                <button
                    type="submit"
                    class="btn btn-success">

                    Guardar

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