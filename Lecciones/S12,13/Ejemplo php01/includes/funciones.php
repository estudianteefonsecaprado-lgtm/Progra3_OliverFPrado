<?php

function calcularPromedio(array $notas): float
{
    return array_sum($notas) / count($notas);
}

function obtenerEstado(float $promedio, float $notaMinima = 70.0): string
{
    return $promedio >= $notaMinima ? "Aprobado" : "Reprobado";
}

function obtenerLetras(float $promedio): string
{
    return match (true) {
        $promedio >= 90 => "A",
        $promedio >= 80 => "B",
        $promedio >= 70 => "C",
        $promedio >= 60 => "D",
        default => "F",
    };
}

?>