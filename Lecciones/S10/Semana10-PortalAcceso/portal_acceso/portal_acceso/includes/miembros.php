<?php

$miembros = [
    ['nombre' => 'Ana Calderón Vargas',      'area' => 'Frontend', 'nivel' => 'Intermedio'],
    ['nombre' => 'Luis Jiménez Rojas',       'area' => 'Backend',  'nivel' => 'Avanzado'],
    ['nombre' => 'María Fernanda Solís',     'area' => 'Frontend', 'nivel' => 'Principiante'],
    ['nombre' => 'Carlos Mora Alfaro',       'area' => 'Backend',  'nivel' => 'Intermedio'],
    ['nombre' => 'Gabriela Ureña Castro',    'area' => 'Datos',    'nivel' => 'Avanzado'],
    ['nombre' => 'Diego Navarro Quesada',    'area' => 'Datos',    'nivel' => 'Principiante'],
    ['nombre' => 'Sofía Ramírez Blanco',     'area' => 'Frontend', 'nivel' => 'Avanzado'],
    ['nombre' => 'Andrés Villalobos Méndez', 'area' => 'Backend',  'nivel' => 'Principiante'],
];

 // Filtra el directorio por texto libre y por area

function filtrarMiembros(array $miembros, string $texto, string $area): array{
    $texto = trim($texto);

    return array_values(array_filter($miembros, function(array $miembro) use ($texto, $area):bool{
        $coincideTexto = $texto === '' || stripos($miembro['nombre'], $texto) !== false;
        $coincidenciaArea = $area === '' || $miembro['area'] === $area;

        return $coincideTexto && $coincidenciaArea;
    }));
}
?>