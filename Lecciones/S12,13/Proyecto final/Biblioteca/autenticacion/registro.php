<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: registro.php
 * Descripción:
 * Muestra el formulario para registrar nuevos usuarios en
 * el sistema de gestión de biblioteca.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

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

    <title>Registro de Usuario</title>

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
        href="../css/estilos.css">

</head>

<body class="bg-light">

<!-- ==========================================================
     Contenedor principal
=========================================================== -->

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-12 col-md-7 col-lg-5">

            <!-- ==================================================
                 Tarjeta del formulario de registro
            =================================================== -->

            <div class="card shadow">

                <!-- Encabezado -->

                <div class="card-header card-header-personalizado text-center">

                    <h2>

                        <i class="bi bi-person-plus-fill"></i>

                        Registro

                    </h2>

                    <p class="mb-0">

                        Crear una cuenta nueva

                    </p>

                </div>

                <div class="card-body p-4">

                    <!-- ==================================================
                         Formulario de registro
                    =================================================== -->

                    <form
                        action="guardar_usuario.php"
                        method="POST"
                        autocomplete="off">

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
                                maxlength="50"
                                autocomplete="off"
                                required>

                        </div>

                        <!-- Campo: Apellido -->

                        <div class="mb-3">

                            <label
                                for="apellido"
                                class="form-label">

                                Apellido

                            </label>

                            <input
                                type="text"
                                id="apellido"
                                name="apellido"
                                class="form-control"
                                maxlength="50"
                                autocomplete="off"
                                required>

                        </div>

                        <!-- Campo: Correo electrónico -->

                        <div class="mb-3">

                            <label
                                for="correo"
                                class="form-label">

                                Correo electrónico

                            </label>

                            <input
                                type="email"
                                id="correo"
                                name="correo"
                                class="form-control"
                                maxlength="100"
                                autocomplete="off"
                                spellcheck="false"
                                required>

                        </div>

                        <!-- Campo: Contraseña -->

                        <div class="mb-4">

                            <label
                                for="contrasena"
                                class="form-label">

                                Contraseña

                            </label>

                            <input
                                type="password"
                                id="contrasena"
                                name="contrasena"
                                class="form-control"
                                minlength="8"
                                maxlength="50"
                                autocomplete="new-password"
                                required>

                            <!-- Mensaje de validación -->

                            <div class="invalid-feedback">

                                La contraseña debe tener al menos 8 caracteres.

                            </div>

                        </div>

                        <!-- Botón para registrar el usuario -->

                        <div class="d-grid">

                            <button
                                type="submit"
                                class="btn btn-success">

                                <i class="bi bi-person-plus-fill"></i>

                                Registrarse

                            </button>

                        </div>

                    </form>

                    <hr>

                    <!-- Enlace para regresar al inicio de sesión -->

                    <div class="text-center">

                        <a
                            href="../index.php"
                            class="fw-semibold">

                            <i class="bi bi-arrow-left"></i>

                            Volver al inicio de sesión

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

<script src="../js/script.js"></script>

</body>

</html>