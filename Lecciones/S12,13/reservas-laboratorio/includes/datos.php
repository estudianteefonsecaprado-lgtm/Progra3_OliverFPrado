<?php
declare(strict_types=1);

// Laboratorios disponibles en el sistema
$laboratoriosValidos = [
    'Lab 1 - Cómputo General',
    'Lab 2 - Redes y Telecomunicaciones',
    'Lab 3 - Inteligencia Artificial',
    'Lab 4 - Desarrollo de Software'
];

// Usuarios encargados autorizados (Contraseña por defecto: j1234567)
$encargados = [
    'oliverprado@castrocarazo.ac.cr' => [
        'nombre' => 'Oliver Fonseca Prado',
        'rol'    => 'Encargado General',
        'hash'   => '$2y$10$JLnonShEzqe.yX7uyNgZ0.BbWMv9asQe5Vtqhz2K7p8xjqZRv46VG',
    ],
    'admin.lab@castrocarazo.ac.cr' => [
        'nombre' => 'Administrador de Laboratorios',
        'rol'    => 'Administrador',
        'hash'   => '$2y$10$JLnonShEzqe.yX7uyNgZ0.BbWMv9asQe5Vtqhz2K7p8xjqZRv46VG',
    ],
];
// Busca un encargado por correo electrónico
function buscarEncargado(string $correo): ?array {
    global $encargados;
    $correo = strtolower(trim($correo));
    return $encargados[$correo] ?? null;
}