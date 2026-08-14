/*=============================================================
Proyecto Final - Programación III
Sistema de Gestión de Biblioteca
---------------------------------------------------------------
Archivo: biblioteca.sql

Descripción:
Script para crear la base de datos, tablas,
relaciones y registros iniciales del Sistema
de Gestión de Biblioteca.

Autor: Oliver Fonseca Prado
Universidad Castro Carazo
=============================================================*/

DROP DATABASE IF EXISTS biblioteca;

CREATE DATABASE biblioteca
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE biblioteca;

-- ============================================================
-- Tabla: usuarios
-- Almacena la información de los usuarios del sistema.
-- ============================================================

CREATE TABLE usuarios (

    id_usuario INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,

    apellido VARCHAR(100) NOT NULL,

    correo VARCHAR(150) NOT NULL UNIQUE,

    contrasena VARCHAR(255) NOT NULL,

    rol ENUM('Administrador', 'Usuario') NOT NULL,

    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;


/*=============================================================
Tabla: autores
---------------------------------------------------------------
Almacena la información de los autores de los libros.
=============================================================*/

CREATE TABLE autores (

    id_autor INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,

    apellido VARCHAR(100) NOT NULL

) ENGINE=InnoDB;


/*=============================================================
Tabla: categorias
---------------------------------------------------------------
Almacena las categorías disponibles para los libros.
=============================================================*/

CREATE TABLE categorias (

    id_categoria INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,

    descripcion VARCHAR(255)

) ENGINE=InnoDB;


/*=============================================================
Tabla: libros
---------------------------------------------------------------
Almacena la información de los libros registrados
en la biblioteca.
=============================================================*/

CREATE TABLE libros (

    id_libro INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(150) NOT NULL,

    anio INT NOT NULL,

    imagen VARCHAR(255),

    disponible BOOLEAN DEFAULT TRUE,

    id_autor INT NOT NULL,

    id_categoria INT NOT NULL,

    CONSTRAINT fk_libro_autor
        FOREIGN KEY (id_autor)
        REFERENCES autores(id_autor)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_libro_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

) ENGINE=InnoDB;


/*=============================================================
Registros iniciales - Usuarios
=============================================================*/

INSERT INTO usuarios (
    nombre,
    apellido,
    correo,
    contrasena,
    rol
)
VALUES
(
    'Oliver',
    'Fonseca',
    'admin@biblioteca.com',
    '$2y$10$/LeDPrFIXv7ZP8yCji1PwOPw3cIjxV8VnqYaJIfXRiC//PB.BZdJK',
    'Administrador'
);


/*=============================================================
Registros iniciales - Autores
=============================================================*/

INSERT INTO autores (nombre, apellido)
VALUES
('Alice', 'Oseman'),
('Julio', 'Verne'),
('Isabel', 'Allende');


/*=============================================================
Registros iniciales - Categorías
=============================================================*/

INSERT INTO categorias (nombre, descripcion)
VALUES
('Novela', 'Libros de narrativa y ficción.'),
('Ciencia', 'Libros relacionados con la ciencia.'),
('Historia', 'Libros sobre acontecimientos históricos.');


/*=============================================================
Registros iniciales - Libros
=============================================================*/

INSERT INTO libros (
    titulo,
    anio,
    imagen,
    disponible,
    id_autor,
    id_categoria
)
VALUES

(
    'Radio Silencio',
    2016,
    'photo.jpg',
    TRUE,
    1,
    1
),

(
    'Viaje al centro de la Tierra',
    1864,
    'viaje_centro_tierra.jpg',
    TRUE,
    2,
    2
),
(
    'La casa de los espíritus',
    1982,
    'casa_espiritus.jpg',
    TRUE,
    3,
    1
);