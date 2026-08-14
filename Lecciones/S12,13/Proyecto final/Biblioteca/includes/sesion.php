<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: sesion.php
 * Descripción:
 * Administra las sesiones del sistema y proporciona
 * funciones para verificar el acceso de los usuarios.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */


// ============================================================
// Iniciar sesión
// ============================================================

function iniciarSesion()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}


// ============================================================
// Verificar si el usuario inició sesión
// ============================================================

function usuarioAutenticado()
{
    iniciarSesion();

    return isset($_SESSION["id_usuario"]);
}


// ============================================================
// Cerrar sesión
// ============================================================

function cerrarSesion()
{
    iniciarSesion();

    $_SESSION = [];

    session_destroy();
}

// ============================================================
// Proteger páginas privadas
// ============================================================

function protegerPagina()
{
    if (!usuarioAutenticado()) {

        header("Location: ../index.php");

        exit;

    }
}