<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: eliminar.php
 * Descripción:
 * Elimina un autor del sistema.
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
// Obtener el ID del autor
// ============================================================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;


// ============================================================
// Eliminar autor
// ============================================================

if ($id > 0) {

    $sql = "DELETE FROM autores
            WHERE id_autor = ?";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param("i", $id);

    try {

        $consulta->execute();

    } catch (mysqli_sql_exception $error) {

        die("No se puede eliminar el autor porque está asociado a uno o más libros.");

    }

    $consulta->close();

}


// ============================================================
// Cerrar conexión
// ============================================================

$conexion->close();


// ============================================================
// Regresar al listado
// ============================================================

redireccionar("listar.php");

?>