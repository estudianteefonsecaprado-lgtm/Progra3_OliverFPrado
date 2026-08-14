-- Connect To MSSQL

DROP DATABASE IF EXISTS gestor_incidencias;

CREATE DATABASE gestor_incidencias
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE gestor_incidencias;

CREATE TABLE departamentos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL UNIQUE
) ENGINE = InnoDB;

CREATE TABLE incidencias(
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(120) NOT NULL,
    descripcion TEXT NOT NULL,
    departamento_id INT NOT NULL,
    prioridad ENUM('baja', 'media', 'alta') NOT NULL DEFAULT 'media',
    estado ENUM('abierta', 'en_proceso', 'cerrado') NOT NULL DEFAULT 'abierta',
    creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (departamento_id) REFERENCES departamentos(id)
)ENGINE = InnoDB;