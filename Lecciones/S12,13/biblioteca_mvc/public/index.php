<?php

require_once '../app/config/Database.php';
require_once '../app/models/Libro.php';
require_once '../app/controllers/LibroController.php';

$database = new Database();
$pdo = $database->conectar();

$modelo = new Libro($pdo);

$controlador = new LibroController($modelo);
$controlador->procesar();
