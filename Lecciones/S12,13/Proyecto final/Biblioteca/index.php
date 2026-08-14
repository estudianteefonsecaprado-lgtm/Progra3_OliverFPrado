<?php
/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: index.php
 * Descripción:
 * Página principal del sistema. Permite a los usuarios
 * iniciar sesión o registrarse para acceder al sistema.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Iniciar sesión para manejar mensajes y variables del usuario
// ============================================================
session_start();

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

    <title>Sistema de Gestión de Biblioteca</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Estilos -->
    <link
        rel="stylesheet"
        href="css/estilos.css">

</head>

<body class="bg-light">

<!-- ==========================================================
     Contenedor principal
=========================================================== -->

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-12 col-md-7 col-lg-5">

            <!-- ==================================================
                 Tarjeta del formulario de inicio de sesión
            =================================================== -->

            <div class="card shadow">

                <!-- Encabezado -->

                <div class="card-header card-header-personalizado text-center">

                    <h2>

                        <i class="bi bi-book-half"></i>

                        Biblioteca

                    </h2>

                    <p class="mb-0">

                        Sistema de Gestión de Biblioteca

                    </p>

                </div>

                <div class="card-body p-4">

                    <!-- Mensaje de error -->

                    <?php if (isset($_SESSION["error_login"])) { ?>

                        <div class="alert alert-danger">

                            <i class="bi bi-exclamation-triangle-fill"></i>

                            <?= $_SESSION["error_login"]; ?>

                        </div>

                        <?php unset($_SESSION["error_login"]); ?>

                    <?php } ?>

                    <!-- ==================================================
                         Formulario de inicio de sesión
                    =================================================== -->

                    <form
                        action="autenticacion/login.php"
                        method="POST"
                        autocomplete="off">

                        <!-- Campo: Correo electrónico -->

                        <div class="mb-3">

                            <label
                                for="correo"
                                class="form-label">

                                Correo electrónico

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-envelope-fill"></i>

                                </span>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="correo"
                                    name="correo"
                                    autocomplete="username"
                                    placeholder="correo@ejemplo.com"
                                    required>

                            </div>

                        </div>

                        <!-- Campo: Contraseña -->

                        <div class="mb-4">

                            <label
                                for="contrasena"
                                class="form-label">

                                Contraseña

                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-lock-fill"></i>

                                </span>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="contrasena"
                                    name="contrasena"
                                    autocomplete="off"
                                    required>

                                <!-- Mostrar u ocultar contraseña -->

                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    id="mostrarContrasena">

                                    <i class="bi bi-eye"></i>

                                </button>

                            </div>

                        </div>

                        <!-- Botón para iniciar sesión -->

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-libros">

                                <i class="bi bi-box-arrow-in-right"></i>

                                Iniciar sesión

                            </button>

                        </div>

                    </form>

                    <hr>

                    <!-- Enlace para registrar un nuevo usuario -->

                    <div class="text-center">

                        ¿No tienes una cuenta?

                        <a
                            href="autenticacion/registro.php"
                            class="fw-semibold">

                            Regístrate aquí

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript del proyecto -->

<script src="js/script.js"></script>

</body>

</html>