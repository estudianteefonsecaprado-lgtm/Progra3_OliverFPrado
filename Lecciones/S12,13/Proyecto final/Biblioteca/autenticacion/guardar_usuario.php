<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: guardar_usuario.php
 * Descripción:
 * Procesa el registro de nuevos usuarios.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

require_once("../includes/conexion.php");
require_once("../includes/funciones.php");


// ============================================================
// Verificar que el formulario fue enviado
// ============================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    redireccionar("../index.php");

}


// ============================================================
// Obtener datos del formulario
// ============================================================

$nombre = limpiarTexto($_POST["nombre"]);
$apellido = limpiarTexto($_POST["apellido"]);
$correo = limpiarTexto($_POST["correo"]);
$contrasena = $_POST["contrasena"];


// ============================================================
// Verificar si el correo ya existe
// ============================================================

$sql = "SELECT id_usuario FROM usuarios WHERE correo = ?";

$consulta = $conexion->prepare($sql);

$consulta->bind_param("s", $correo);

$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {

    die("El correo electrónico ya está registrado.");

}


// ============================================================
// Generar hash de la contraseña
// ============================================================

$contrasenaHash = generarHash($contrasena);


// ============================================================
// Registrar usuario
// ============================================================

$sql = "INSERT INTO usuarios
        (nombre, apellido, correo, contrasena, rol)
        VALUES (?, ?, ?, ?, ?)";

$consulta = $conexion->prepare($sql);

$rol = "Usuario";

$consulta->bind_param(

    "sssss",

    $nombre,
    $apellido,
    $correo,
    $contrasenaHash,
    $rol

);


// ============================================================
// Guardar y redireccionar
// ============================================================

if ($consulta->execute()) {

    redireccionar("../index.php");

} else {

    die("No fue posible registrar el usuario.");

}


// ============================================================
// Cerrar conexión
// ============================================================

$consulta->close();

$conexion->close();