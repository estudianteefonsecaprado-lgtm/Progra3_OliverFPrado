<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: agregar.php
 * Descripción:
 * Permite registrar un nuevo usuario desde el panel
 * de administración.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios del proyecto
// ============================================================

// Archivo que crea la conexión con la base de datos MySQL.
require_once("../../includes/conexion.php");

// Archivo donde se encuentran funciones reutilizables
// como limpiarTexto(), generarHash() y redireccionar().
require_once("../../includes/funciones.php");

// Archivo encargado del manejo de sesiones y control
// de acceso de los usuarios autenticados.
require_once("../../includes/sesion.php");

// ============================================================
// Verificar que exista una sesión iniciada
// ============================================================

// Si el usuario no ha iniciado sesión,
// será enviado automáticamente a la página de inicio de sesión.
protegerPagina();

// ============================================================
// Restringir el acceso únicamente a administradores
// ============================================================

// Se verifica el rol almacenado en la sesión.
// Si el usuario autenticado no es administrador,
// no podrá acceder a esta página.
if ($_SESSION["rol"] != "Administrador") {

    // Redirigir al inicio para evitar acceso no autorizado.
    redireccionar("../../inicio.php");
}

// ============================================================
// Procesar el formulario cuando se envía
// ============================================================

// El código únicamente se ejecuta cuando el formulario
// es enviado mediante el método POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ========================================================
    // Obtener y limpiar los datos enviados por el formulario
    // ========================================================

    // Eliminar espacios innecesarios y caracteres peligrosos.
    $nombre = limpiarTexto($_POST["nombre"]);

    $apellido = limpiarTexto($_POST["apellido"]);

    $correo = limpiarTexto($_POST["correo"]);

    // La contraseña nunca se guarda en texto plano.
    // Se convierte en un hash seguro antes de almacenarla.
    $contrasena = generarHash($_POST["contrasena"]);

    // Obtener el rol seleccionado.
    $rol = $_POST["rol"];

    // ========================================================
    // Crear la consulta SQL preparada
    // ========================================================

    // Se utiliza una consulta preparada para prevenir
    // ataques de inyección SQL.
    $sql = "INSERT INTO usuarios
            (nombre, apellido, correo, contrasena, rol)
            VALUES (?, ?, ?, ?, ?)";

    // Preparar la consulta.
    $stmt = $conexion->prepare($sql);

    // ========================================================
    // Asociar los valores a la consulta
    // ========================================================

    // "sssss" indica que los cinco parámetros
    // son de tipo string.
    $stmt->bind_param(
        "sssss",
        $nombre,
        $apellido,
        $correo,
        $contrasena,
        $rol
    );

    // ========================================================
    // Ejecutar la inserción
    // ========================================================

    // Guardar el nuevo usuario en la base de datos.
    $stmt->execute();

    // Liberar recursos cerrando la consulta preparada.
    $stmt->close();

    // ========================================================
    // Regresar al listado de usuarios
    // ========================================================

    // Después de guardar correctamente,
    // redirigir al listado principal.
    redireccionar("listar.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Codificación para permitir caracteres especiales -->
    <meta charset="UTF-8">

    <!-- Adaptar la página a dispositivos móviles -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <!-- Título mostrado en la pestaña del navegador -->
    <title>Agregar usuario</title>

    <!-- ==================================================== -->
    <!-- Bootstrap -->
    <!-- ==================================================== -->

    <!-- Framework CSS utilizado para el diseño del formulario -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- ==================================================== -->
    <!-- Bootstrap Icons -->
    <!-- ==================================================== -->

    <!-- Biblioteca de iconos utilizada en botones y encabezados -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- ==================================================== -->
    <!-- Hoja de estilos personalizada -->
    <!-- ==================================================== -->

    <!-- Estilos propios del proyecto -->
    <link
        rel="stylesheet"
        href="../../css/estilos.css">

</head>

<body>

<div class="row justify-content-center">

    <!-- Columna principal del formulario -->
    <div class="col-lg-9">

        <!-- Tarjeta que contiene todo el formulario -->
        <div class="card shadow">

            <!-- Encabezado -->
            <div class="card-header card-header-personalizado">

                <h3>

                    <!-- Icono decorativo -->
                    <i class="bi bi-person-plus-fill"></i>

                    Agregar usuario

                </h3>

            </div>

            <!-- Contenido -->
            <div class="card-body">

                <!-- Formulario -->
                <form
                    method="POST"
                    autocomplete="off">

                    <!-- =============================== -->
                    <!-- Nombre -->
                    <!-- =============================== -->

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
                            autocomplete="off"
                            required>

                    </div>

                    <!-- =============================== -->
                    <!-- Apellido -->
                    <!-- =============================== -->

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
                            autocomplete="off"
                            required>

                    </div>

                    <!-- =============================== -->
                    <!-- Correo -->
                    <!-- =============================== -->

                    <div class="mb-3">

                        <label
                            for="correo"
                            class="form-label">

                            Correo electrónico

                        </label>

                        <!-- Campo tipo email para una validación básica -->
                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            class="form-control"
                            autocomplete="off"
                            required>

                    </div>

                    <!-- =============================== -->
                    <!-- Contraseña -->
                    <!-- =============================== -->

                    <div class="mb-3">

                        <label
                            for="contrasena"
                            class="form-label">

                            Contraseña

                        </label>

                        <!-- Se solicita una contraseña mínima de 8 caracteres -->
                        <input
                            type="password"
                            id="contrasena"
                            name="contrasena"
                            class="form-control"
                            autocomplete="new-password"
                            minlength="8"
                            required>

                        <!-- Mensaje de validación -->
                        <div class="invalid-feedback">

                            La contraseña debe tener al menos 8 caracteres.

                        </div>

                    </div>

                    <!-- =============================== -->
                    <!-- Rol -->
                    <!-- =============================== -->

                    <div class="mb-4">

                        <label
                            for="rol"
                            class="form-label">

                            Rol

                        </label>

                        <!-- Selección del tipo de usuario -->
                        <select
                            id="rol"
                            name="rol"
                            class="form-select">

                            <option value="Administrador">

                                Administrador

                            </option>

                            <option value="Usuario">

                                Usuario

                            </option>

                        </select>

                    </div>

                    <!-- =============================== -->
                    <!-- Botones -->
                    <!-- =============================== -->

                    <div class="d-flex gap-2">

                        <!-- Guardar -->
                        <button
                            type="submit"
                            class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            Guardar

                        </button>

                        <!-- Cancelar -->
                        <a
                            href="listar.php"
                            class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>

                            Cancelar

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>

</html>

<?php

$conexion->close();

?>