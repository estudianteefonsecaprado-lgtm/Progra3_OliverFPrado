<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: listar.php
 * Descripción:
 * Muestra el listado de autores registrados.
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
// Consultar autores registrados
// ============================================================

$sql = "SELECT * FROM autores ORDER BY apellido ASC, nombre ASC";

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

    <title>Autores</title>

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

            Autores

        </h2>

        <!-- Botón para registrar un nuevo autor -->

        <a
            href="agregar.php"
            class="btn btn-success">

            <i class="bi bi-plus-circle"></i>

            Agregar autor

        </a>

    </div>

    <!-- Tabla con el listado de autores -->

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Nombre</th>

                <th>Apellido</th>

                <th class="text-center">

                    Acciones

                </th>

            </tr>

        </thead>

        <tbody>

        <!-- Recorrer todos los autores obtenidos de la base de datos -->

        <?php while ($autor = $resultado->fetch_assoc()) { ?>

            <tr>

                <td>

                    <?= $autor["id_autor"]; ?>

                </td>

                <td>

                    <?= $autor["nombre"]; ?>

                </td>

                <td>

                    <?= $autor["apellido"]; ?>

                </td>

                <!-- Botones para editar o eliminar el registro -->

                <td class="text-center">

                    <a
                        href="editar.php?id=<?= $autor["id_autor"]; ?>"
                        class="btn btn-warning btn-sm me-2">

                        Editar

                    </a>

                    <a
                        href="eliminar.php?id=<?= $autor["id_autor"]; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este autor?');">

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