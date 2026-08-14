<?php 
/**  
 * * ============================================================  
 * * Proyecto Final - Programación III  
 * * Sistema de Gestión de Biblioteca  
 * * ------------------------------------------------------------  
 * * Archivo: conexion.php  
 * * Descripción:  
 * * Este archivo establece la conexión con la base de datos  
 * * utilizando la extensión MySQLi.  *  
 * * Todas las páginas del proyecto reutilizarán esta conexión.  
 * *  * Autor: Oliver Fonseca Prado  
 * * Universidad Castro Carazo  
 * * ============================================================  
 */

// ============================================================
// Configuración de la base de datos
// ============================================================

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$baseDatos = "biblioteca";

// ============================================================
// Configuración de MySQLi
// ============================================================

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ============================================================
// Crear conexión con la base de datos
// ============================================================

try {

    $conexion = new mysqli(
        $servidor,
        $usuario,
        $contrasena,
        $baseDatos
    );

   // Configurar la codificación de caracteres
    $conexion->set_charset("utf8mb4");

} catch (Exception $error) {

    die("Error: No fue posible conectar con la base de datos.");

}
