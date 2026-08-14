<?php
/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: inicio.php
 * Descripción:
 * Página principal del sistema después del inicio de sesión.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

require_once("includes/funciones.php");
require_once("includes/sesion.php");

// ============================================================
// Verificar sesión
// ============================================================

protegerPagina();

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

    <title>Inicio</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Hoja de estilos personalizada -->

    <link
        rel="stylesheet"
        href="css/estilos.css">

</head>

<body>

<!-- ==========================================================
     Barra de navegación
=========================================================== -->

<nav class="navbar navbar-dark">

    <div class="container">

        <!-- Nombre del sistema -->

        <span class="navbar-brand">

            <i class="bi bi-book-half"></i>

            Biblioteca

        </span>

        <!-- Botón para cerrar la sesión -->

        <a
            href="autenticacion/cerrar_sesion.php"
            class="btn btn-light">

            <i class="bi bi-box-arrow-right"></i>

            Cerrar sesión

        </a>

    </div>

</nav>

<!-- ==========================================================
     Contenido principal
=========================================================== -->

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <!-- Mensaje de bienvenida -->

            <h2>

                Bienvenido,
                <?= $_SESSION["nombre"]; ?>

            </h2>

            <!-- Rol del usuario -->

            <p>

                Rol:
                <strong>

                    <?= $_SESSION["rol"]; ?>

                </strong>

            </p>

            <hr>

            <!-- Accesos a los módulos principales -->

            <div class="row">

                <!-- Módulo de Libros -->

                <div class="col-md-4 mb-3">

                    <a
                        href="modulos/libros/listar.php"
                        class="btn btn-libros w-100">

                        📚 Libros

                    </a>

                </div>

                <!-- Módulo de Autores -->

                <div class="col-md-4 mb-3">

                    <a
                        href="modulos/autores/listar.php"
                        class="btn btn-autores w-100">

                        ✍️ Autores

                    </a>

                </div>

                <!-- Módulo de Categorías -->

                <div class="col-md-4 mb-3">

                    <a
                        href="modulos/categorias/listar.php"
                        class="btn btn-categorias w-100">

                        🏷️ Categorías

                    </a>

                </div>

            </div>

            <!-- Opciones exclusivas para administradores -->

            <?php if ($_SESSION["rol"] == "Administrador") { ?>

                <hr>

                <a
                    href="modulos/usuarios/listar.php"
                    class="btn btn-libros">

                    <i class="bi bi-people-fill"></i>

                    Administrar usuarios

                </a>

            <?php } ?>

        </div>

    </div>

</div>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript del proyecto -->

<script src="js/script.js"></script>

</body>

</html>