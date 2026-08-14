<?php
declare(strict_types=1);

require_once __DIR__ . '/seguridad.php';

// Obtiene las solicitudes almacenadas en la sesión
function obtenerSolicitudes(): array
{
    iniciarSesion();

    if (!isset($_SESSION['solicitudes'])) {
        $_SESSION['solicitudes'] = [
            [
                'id' => 'REQ-001',
                'nombre' => 'Carlos Morales',
                'correo' => 'cmorales@est.castrocarazo.ac.cr',
                'carne' => '10241024',
                'laboratorio' => 'Lab 1 - Cómputo General',
                'fecha' => date('Y-m-d', strtotime('+2 days')),
                'hora' => '14:00',
                'equipos' => 15,
                'motivo' => 'Taller práctico de Base de Datos I.',
                'estado' => 'pendiente'
            ],
            [
                'id' => 'REQ-002',
                'nombre' => 'María Vargas',
                'correo' => 'mvargas@est.castrocarazo.ac.cr',
                'carne' => '20482048',
                'laboratorio' => 'Lab 3 - Inteligencia Artificial',
                'fecha' => date('Y-m-d', strtotime('+3 days')),
                'hora' => '18:00',
                'equipos' => 10,
                'motivo' => 'Sesión grupal de investigación de Redes Neuronales.',
                'estado' => 'aprobada'
            ]
        ];
    }

    return $_SESSION['solicitudes'];
}

// Agrega una nueva solicitud
function agregarSolicitud(array $datos): void
{
    iniciarSesion();

    obtenerSolicitudes();

    $numero = count($_SESSION['solicitudes']) + 1;

    $datos['id'] = 'REQ-' . str_pad((string)$numero, 3, '0', STR_PAD_LEFT);
    $datos['estado'] = 'pendiente';

    array_unshift($_SESSION['solicitudes'], $datos);
}

// Filtra solicitudes
function filtrarSolicitudes(
    array $solicitudes,
    string $texto,
    string $estado,
    string $laboratorio
): array {

    $texto = mb_strtolower(trim($texto));

    return array_values(array_filter(
        $solicitudes,
        function (array $req) use ($texto, $estado, $laboratorio): bool {

            $coincideTexto =
                $texto === ''
                || str_contains(mb_strtolower($req['nombre']), $texto)
                || str_contains(mb_strtolower($req['carne']), $texto);

            $coincideEstado =
                $estado === ''
                || $req['estado'] === $estado;

            $coincideLaboratorio =
                $laboratorio === ''
                || $req['laboratorio'] === $laboratorio;

            return $coincideTexto && $coincideEstado && $coincideLaboratorio;
        }
    ));
}

// Cambia el estado de una solicitud
function actualizarEstadoSolicitud(string $id, string $nuevoEstado): bool
{
    iniciarSesion();

    $estadosValidos = [
        'pendiente',
        'aprobada',
        'rechazada'
    ];

    if (!in_array($nuevoEstado, $estadosValidos, true)) {
        return false;
    }

    if (!isset($_SESSION['solicitudes'])) {
        return false;
    }

    foreach ($_SESSION['solicitudes'] as &$solicitud) {

        if ($solicitud['id'] === $id) {
            $solicitud['estado'] = $nuevoEstado;
            return true;
        }
    }

    return false;
}