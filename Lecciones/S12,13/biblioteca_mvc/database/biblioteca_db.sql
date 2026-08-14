-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS biblioteca_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Seleccionar la base de datos
USE biblioteca_db;

-- Crear la tabla libros
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    anio_publicacion INT NOT NULL,
    genero VARCHAR(50) NOT NULL,
    isbn VARCHAR(20) NULL,
    disponible TINYINT(1) NOT NULL
);

-- Registros de prueba
INSERT INTO libros (titulo, autor, anio_publicacion, genero, isbn, disponible)
VALUES
('Heartstopper Vol. 1', 'Alice Oseman', 2019, 'Novela gráfica', '9781444951387', 1),

('Heartstopper Vol. 2', 'Alice Oseman', 2019, 'Romance', '9781444951394', 0),

('Heartstopper Vol. 3', 'Alice Oseman', 2020, 'Juvenil', NULL, 1),

('Heartstopper Vol. 4', 'Alice Oseman', 2021, 'Novela gráfica', '9781444952773', 0);