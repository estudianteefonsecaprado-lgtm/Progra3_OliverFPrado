<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: listar.php
 * Descripción:
 * Muestra el listado de categorías registradas.
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
// Consultar categorías registradas
// ============================================================

$sql = "SELECT * FROM categorias ORDER BY nombre ASC";

$resultado = $conexion->query($sql);

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

    <title>Categorías</title>

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

    <!-- Encabezado del módulo -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Categorías

        </h2>

        <!-- Botón para registrar una nueva categoría -->

        <a
            href="agregar.php"
            class="btn btn-success">

            <i class="bi bi-plus-circle"></i>

            Agregar categoría

        </a>

    </div>

    <!-- Tabla con el listado de categorías -->

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th class="text-center">

                    ID

                </th>

                <th class="columna-nombre">

                    Nombre

                </th>

                <th>

                    Descripción

                </th>

                <th class="columna-acciones">

                    Acciones

                </th>

            </tr>

        </thead>

        <tbody>

        <!-- Recorrer todas las categorías obtenidas de la base de datos -->

        <?php while ($categoria = $resultado->fetch_assoc()) { ?>

            <tr>

                <td class="text-center">

                    <?= $categoria["id_categoria"]; ?>

                </td>

                <td>

                    <?= $categoria["nombre"]; ?>

                </td>

                <td>

                    <?= $categoria["descripcion"]; ?>

                </td>

                <!-- Botones para editar o eliminar la categoría -->

                <td class="text-center">

                    <a
                        href="editar.php?id=<?= $categoria["id_categoria"]; ?>"
                        class="btn btn-warning btn-sm me-2">

                        Editar

                    </a>

                    <a
                        href="eliminar.php?id=<?= $categoria["id_categoria"]; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar esta categoría?');">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <!-- Botón para regresar al menú principal -->

    <a
        href="../../inicio.php"
        class="btn btn-secondary">

        Volver

    </a>

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