<?php

$usuarios = [
    'ana.calderon@castrocarazo.ac.cr' => [
        'nombre' => 'Ana Calderón Vargas',
        'rol'    => 'Estudiante',
        'hash'   => '$2y$10$JLnonShEzqe.yX7uyNgZ0.BbWMv9asQe5Vtqhz2K7p8xjqZRv46VG',
    ],
    'luis.jimenez@castrocarazo.ac.cr' => [
        'nombre' => 'Luis Jiménez Rojas',
        'rol'    => 'Estudiante',
        'hash'   => '$2y$10$JLnonShEzqe.yX7uyNgZ0.BbWMv9asQe5Vtqhz2K7p8xjqZRv46VG',
    ],
    'jelizondoc@castrocarazo.ac.cr' => [
        'nombre' => 'Jeremy Elizondo Castro',
        'rol'    => 'Docente',
        'hash'   => '$2y$10$JLnonShEzqe.yX7uyNgZ0.BbWMv9asQe5Vtqhz2K7p8xjqZRv46VG',
    ],
];
// Contraseña j1234567.

function buscarUsuario(string $correo): ?array{
    global $usuarios;

    $correo = strtolower(trim($correo));

    return $usuarios[$correo] ?? null;
}

?>