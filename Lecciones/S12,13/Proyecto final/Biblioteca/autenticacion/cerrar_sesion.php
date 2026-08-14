<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: cerrar_sesion.php
 * Descripción:
 * Cierra la sesión del usuario y lo redirecciona
 * a la pantalla de inicio de sesión.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

require_once("../includes/funciones.php");
require_once("../includes/sesion.php");

// ============================================================
// Cerrar sesión
// ============================================================

cerrarSesion();

// ============================================================
// Redireccionar al inicio
// ============================================================

redireccionar("../index.php");