<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: eliminar.php
 * Descripción:
 * Elimina un libro y su imagen de portada.
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
// Obtener ID del libro
// ============================================================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id > 0) {

    // ========================================================
    // Obtener el nombre de la imagen
    // ========================================================

    $sql = "SELECT imagen
            FROM libros
            WHERE id_libro = ?";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param("i", $id);

    $consulta->execute();

    $resultado = $consulta->get_result();

    $libro = $resultado->fetch_assoc();

    $consulta->close();

    // ========================================================
    // Eliminar la imagen si existe
    // ========================================================

    if (
        !empty($libro["imagen"]) &&
        file_exists("../../imagenes/portadas/" . $libro["imagen"])
    ) {

        unlink("../../imagenes/portadas/" . $libro["imagen"]);

    }

    // ========================================================
    // Eliminar el libro
    // ========================================================

    $sql = "DELETE FROM libros
            WHERE id_libro = ?";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param("i", $id);

    $consulta->execute();

    $consulta->close();

}

// ============================================================
// Cerrar conexión
// ============================================================

$conexion->close();

// ============================================================
// Volver al listado
// ============================================================

redireccionar("listar.php");

?>