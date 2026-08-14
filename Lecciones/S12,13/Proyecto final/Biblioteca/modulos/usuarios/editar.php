<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: editar.php
 * Descripción:
 * Permite editar la información de un usuario registrado.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios del proyecto
// ============================================================

// Archivo encargado de establecer la conexión
// con la base de datos MySQL.
require_once("../../includes/conexion.php");

// Archivo que contiene funciones reutilizables,
// como limpiarTexto() y redireccionar().
require_once("../../includes/funciones.php");

// Archivo responsable del manejo de sesiones
// y del control de acceso de los usuarios.
require_once("../../includes/sesion.php");

// ============================================================
// Verificar que exista una sesión iniciada
// ============================================================

// Si el usuario no ha iniciado sesión,
// será redirigido automáticamente.
protegerPagina();

// ============================================================
// Verificar que el usuario sea administrador
// ============================================================

// Solo los administradores pueden modificar
// la información de otros usuarios.
if ($_SESSION["rol"] != "Administrador") {

    // Si no tiene permisos suficientes,
    // regresar a la página principal.
    redireccionar("../../inicio.php");
}

// ============================================================
// Obtener y validar el ID del usuario
// ============================================================

// Comprobar que el parámetro "id" exista
// y que sea un número válido.
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    // Si el ID es inválido,
    // volver al listado de usuarios.
    redireccionar("listar.php");
}

// Convertir el ID recibido a entero
// para trabajar únicamente con valores numéricos.
$id = intval($_GET["id"]);

// ============================================================
// Buscar el usuario en la base de datos
// ============================================================

// Consulta para obtener toda la información
// del usuario seleccionado.
$sql = "SELECT * FROM usuarios
        WHERE id_usuario = ?";

// Preparar la consulta SQL.
$stmt = $conexion->prepare($sql);

// Asociar el ID como parámetro entero.
$stmt->bind_param("i", $id);

// Ejecutar la consulta.
$stmt->execute();

// Obtener el resultado.
$resultado = $stmt->get_result();

// ============================================================
// Verificar que el usuario exista
// ============================================================

// Si no existe ningún registro con ese ID,
// cerrar recursos y regresar al listado.
if ($resultado->num_rows == 0) {

    $stmt->close();

    $conexion->close();

    redireccionar("listar.php");
}

// Obtener la información del usuario
// como un arreglo asociativo.
$usuario = $resultado->fetch_assoc();

// Cerrar la consulta SELECT
// porque ya no será utilizada.
$stmt->close();

// ============================================================
// Actualizar la información del usuario
// ============================================================

// Solo ejecutar este bloque cuando
// el formulario sea enviado.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener los datos del formulario
    // y limpiarlos antes de utilizarlos.
    $nombre = limpiarTexto($_POST["nombre"]);

    $apellido = limpiarTexto($_POST["apellido"]);

    $correo = limpiarTexto($_POST["correo"]);

    // Obtener el rol seleccionado.
    $rol = $_POST["rol"];

    // ========================================================
    // Crear consulta UPDATE
    // ========================================================

    // Consulta preparada para actualizar
    // la información del usuario.
    $sql = "UPDATE usuarios
            SET nombre = ?,
                apellido = ?,
                correo = ?,
                rol = ?
            WHERE id_usuario = ?";

    // Preparar la consulta.
    $stmt = $conexion->prepare($sql);

    // ========================================================
    // Asociar parámetros
    // ========================================================

    // "ssssi" significa:
    // s = string
    // i = integer
    $stmt->bind_param(
        "ssssi",
        $nombre,
        $apellido,
        $correo,
        $rol,
        $id
    );

    // Ejecutar la actualización.
    $stmt->execute();

    // Cerrar la consulta.
    $stmt->close();

    // Cerrar la conexión con la base de datos.
    $conexion->close();

    // Regresar al listado de usuarios.
    redireccionar("listar.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Permitir caracteres especiales -->
    <meta charset="UTF-8">

    <!-- Adaptar la página a dispositivos móviles -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <!-- Título mostrado en el navegador -->
    <title>Editar usuario</title>

    <!-- ==================================================== -->
    <!-- Bootstrap -->
    <!-- ==================================================== -->

    <!-- Framework CSS utilizado para el diseño -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- ==================================================== -->
    <!-- Bootstrap Icons -->
    <!-- ==================================================== -->

    <!-- Biblioteca de iconos utilizada en la interfaz -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- ==================================================== -->
    <!-- Estilos personalizados -->
    <!-- ==================================================== -->

    <link
        rel="stylesheet"
        href="../../css/estilos.css">

</head>

<body>

<div class="row justify-content-center">

    <!-- Contenedor principal -->
    <div class="col-lg-10">

        <!-- Tarjeta del formulario -->
        <div class="card shadow">

            <!-- Encabezado -->
            <div class="card-header card-header-personalizado">

                <h3>

                    <!-- Icono representativo -->
                    <i class="bi bi-pencil-square"></i>

                    Editar usuario

                </h3>

            </div>

            <!-- Contenido -->
            <div class="card-body">

                <!-- Formulario de edición -->
                <form method="POST">

                    <!-- =========================== -->
                    <!-- Nombre -->
                    <!-- =========================== -->

                    <div class="mb-3">

                        <label class="form-label">

                            Nombre

                        </label>

                        <!-- Mostrar el nombre actual del usuario -->
                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            value="<?= htmlspecialchars($usuario["nombre"]); ?>"
                            required>

                    </div>

                    <!-- =========================== -->
                    <!-- Apellido -->
                    <!-- =========================== -->

                    <div class="mb-3">

                        <label class="form-label">

                            Apellido

                        </label>

                        <!-- Mostrar el apellido actual -->
                        <input
                            type="text"
                            name="apellido"
                            class="form-control"
                            value="<?= htmlspecialchars($usuario["apellido"]); ?>"
                            required>

                    </div>

                    <!-- =========================== -->
                    <!-- Correo -->
                    <!-- =========================== -->

                    <div class="mb-3">

                        <label class="form-label">

                            Correo electrónico

                        </label>

                        <!-- Mostrar el correo actual -->
                        <input
                            type="email"
                            name="correo"
                            class="form-control"
                            value="<?= htmlspecialchars($usuario["correo"]); ?>"
                            required>

                    </div>

                    <!-- =========================== -->
                    <!-- Rol -->
                    <!-- =========================== -->

                    <div class="mb-4">

                        <label class="form-label">

                            Rol

                        </label>

                        <!-- Lista de roles disponibles -->
                        <select
                            name="rol"
                            class="form-select">

                            <!-- Mantener seleccionado el rol actual -->
                            <option
                                value="Administrador"
                                <?= $usuario["rol"] == "Administrador" ? "selected" : ""; ?>>

                                Administrador

                            </option>

                            <option
                                value="Usuario"
                                <?= $usuario["rol"] == "Usuario" ? "selected" : ""; ?>>

                                Usuario

                            </option>

                        </select>

                    </div>

                    <!-- =========================== -->
                    <!-- Botones -->
                    <!-- =========================== -->

                    <div class="d-flex gap-2">

                        <!-- Guardar cambios -->
                        <button
                            type="submit"
                            class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            Actualizar

                        </button>

                        <!-- Cancelar edición -->
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