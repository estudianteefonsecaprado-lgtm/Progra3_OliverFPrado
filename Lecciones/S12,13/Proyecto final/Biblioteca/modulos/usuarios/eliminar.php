<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: eliminar.php
 * Descripción:
 * Elimina un usuario registrado.
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
if ($_SESSION["rol"] != "Administrador") {

    redireccionar("../../inicio.php");

}
// ============================================================
// Solo administradores
// ============================================================

if ($_SESSION["rol"] != "Administrador") {

    redireccionar("../../inicio.php");

}

// ============================================================
// Obtener ID
// ============================================================

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// ============================================================
// Evitar eliminar el propio usuario
// ============================================================

if ($id == $_SESSION["id_usuario"]) {

    redireccionar("listar.php");

}

// ============================================================
// Eliminar usuario
// ============================================================

$sql = "DELETE FROM usuarios
        WHERE id_usuario = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();

$conexion->close();

redireccionar("listar.php");

?>