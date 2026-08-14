<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: listar.php
 * Descripción:
 * Muestra el listado de usuarios registrados.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

// Carga la conexión a la base de datos MySQL mediante el objeto $conexion
require_once("../../includes/conexion.php");

// Carga funciones auxiliares personalizadas (ej. redireccionar)
require_once("../../includes/funciones.php");

// Inicia o reanuda la sesión PHP para acceder a la variable $_SESSION
require_once("../../includes/sesion.php");

// ============================================================
// Verificar sesión
// ============================================================

// Llama a la función que valida si el usuario ha iniciado sesión previamente
protegerPagina();

// Primer control de acceso: Si el usuario no tiene el rol 'Administrador'...
if ($_SESSION["rol"] != "Administrador") {

// ...se redirige mediante la función personalizada redireccionar()
redireccionar("../../inicio.php");


}

// ============================================================
// Solo el administrador puede acceder
// ============================================================

// Control de acceso: Verifica de nuevo si no es 'Administrador'
if ($_SESSION["rol"] != "Administrador") {

// Redirección nativa usando los encabezados HTTP
header("Location: ../../inicio.php");

// Detiene inmediatamente la ejecución del script por seguridad
exit();

}

// ============================================================
// Consultar usuarios
// ============================================================

// Define la consulta SQL para obtener todos los registros de la tabla 'usuarios' ordenados alfabéticamente por nombre
$sql = "SELECT * FROM usuarios ORDER BY nombre ASC";

// Ejecuta la consulta SQL a través de la conexión activa
$resultado = $conexion->query($sql);

?>

<meta charset="UTF-8">

<meta name="viewport"
    content="width=device-width, initial-scale=1.0">

<title>Usuarios</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet">

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link
    rel="stylesheet"
    href="../../css/estilos.css">

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Usuarios</h2>

    <a
        href="agregar.php"
        class="btn btn-success">

        <i class="bi bi-plus-circle"></i>

        Agregar usuario

    </a>

</div>

<table class="table table-bordered table-hover">

    <thead class="table-dark">

        <tr>

            <th class="text-center">ID</th>

            <th>Nombre</th>

            <th>Apellido</th>

            <th>Correo</th>

            <th>Rol</th>

            <th class="text-center">Acciones</th>

        </tr>

    </thead>

    <tbody>

    <?php while ($usuario = $resultado->fetch_assoc()) { ?>

        <tr>

            <td class="text-center">

                <?= $usuario["id_usuario"]; ?>

            </td>

            <td>

                <?= $usuario["nombre"]; ?>

            </td>

            <td>

                <?= $usuario["apellido"]; ?>

            </td>

            <td>

                <?= $usuario["correo"]; ?>

            </td>

            <td>

                <?= $usuario["rol"]; ?>

            </td>

            <td class="text-center">

                <a
                    href="editar.php?id=<?= $usuario["id_usuario"]; ?>"
                    class="btn btn-warning btn-sm me-2">

                    Editar

                </a>

                <a
                    href="eliminar.php?id=<?= $usuario["id_usuario"]; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('¿Desea eliminar este usuario?');">

                    Eliminar

                </a>

            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>

<a
    href="../../inicio.php"
    class="btn btn-secondary">

    Volver

</a>

</body>

</html>

<?php

// Cierra formalmente la conexión a la base de datos para liberar recursos
$conexion->close();

?>