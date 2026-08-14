<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: funciones.php
 * Descripción:
 * Contiene funciones reutilizables utilizadas en todo el
 * sistema para validación, seguridad y operaciones comunes.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */


// ============================================================
// Limpiar texto recibido desde formularios
// ============================================================

function limpiarTexto($texto)
{
    return htmlspecialchars(trim($texto));
}


// ============================================================
// Generar hash seguro para contraseñas
// ============================================================

function generarHash($contrasena)
{
    return password_hash($contrasena, PASSWORD_DEFAULT);
}


// ============================================================
// Verificar contraseña
// ============================================================

function verificarHash($contrasena, $hash)
{
    return password_verify($contrasena, $hash);
}


// ============================================================
// Redireccionar a otra página
// ============================================================

function redireccionar($ruta)
{
    header("Location: $ruta");
    exit;
}