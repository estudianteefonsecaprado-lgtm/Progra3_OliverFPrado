<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: login.php
 * Descripción:
 * Procesa el inicio de sesión de los usuarios.
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
require_once("../includes/sesion.php");

// ============================================================
// Verificar que el formulario fue enviado
// ============================================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    redireccionar("../index.php");

}

// ============================================================
// Obtener datos del formulario
// ============================================================

$correo = limpiarTexto($_POST["correo"]);
$contrasena = $_POST["contrasena"];

// ============================================================
// Buscar usuario por correo
// ============================================================

$sql = "SELECT * FROM usuarios
        WHERE correo = ?";

$consulta = $conexion->prepare($sql);

$consulta->bind_param("s", $correo);

$consulta->execute();

$resultado = $consulta->get_result();

// ============================================================
// Verificar credenciales
// ============================================================

if ($resultado->num_rows === 1) {

    $usuario = $resultado->fetch_assoc();

    if (verificarHash($contrasena, $usuario["contrasena"])) {

        iniciarSesion();

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];

        $consulta->close();
        $conexion->close();

        redireccionar("../inicio.php");

    }

}

// ============================================================
// Credenciales incorrectas
// ============================================================

$_SESSION["error_login"] = "Correo o contraseña incorrectos.";

$consulta->close();
$conexion->close();

redireccionar("../index.php");

?>