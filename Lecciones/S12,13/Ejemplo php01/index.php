<?php
require_once __DIR__ . "/includes/funciones.php";
//declare(strict_types=1);

$curso = "Programación De Computadoras III";

$periodo = "Cuatrimestre II - 2026";

$creditos = 4; // int

$promedioMin = 70.0; // float

$activo = true; // bool

$sinAsignar = null; // null

// var_dump($creditos, $promedioMin, $activo, $sinAsignar);

// echo gettype($activo);

// echo 70 . 78;

$promedioLaura = 80;
$promedioGabriel = 85;
$promedioJeremy = 50;

if ($promedioJeremy >= 70.0) {
    echo "Aprobado\n";
} else {
    echo "Reprobado\n";
}

$letra = match (true) {
    $promedioJeremy >= 90 => "A",
    $promedioJeremy >= 80 => "B",
    $promedioJeremy >= 70 => "C",
    $promedioJeremy >= 60 => "D",
    default => "F",
};
echo $letra;
$prom = calcularPromedio ([90,85,39]);
 echo $prom;
?>