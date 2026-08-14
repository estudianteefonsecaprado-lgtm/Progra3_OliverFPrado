<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: agregar.php
 * Descripción:
 * Permite registrar un nuevo autor.
 *
 * Autor: Oliver Fonseca Prado
 * Universidad Castro Carazo
 * ============================================================
 */

// ============================================================
// Incluir archivos necesarios
// ============================================================

require_once("../../includes/conexion.php");
require_once("../../includes/funciones.php");
require_once("../../includes/sesion.php");

// ============================================================
// Verificar sesión
// ============================================================

protegerPagina();

if ($_SESSION["rol"] != "Administrador") {

    redireccionar("../../inicio.php");

}
// ============================================================
// Guardar autor
// ============================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = limpiarTexto($_POST["nombre"]);
    $apellido = limpiarTexto($_POST["apellido"]);

    $sql = "INSERT INTO autores (nombre, apellido)
            VALUES (?, ?)";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param(
        "ss",
        $nombre,
        $apellido
    );

    if ($consulta->execute()) {

        redireccionar("listar.php");

    } else {

        $mensaje = "No fue posible guardar el autor.";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Agregar autor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="../../css/estilos.css">

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header card-header-personalizado">

            <h3>

                Agregar autor

            </h3>

        </div>

        <div class="card-body">

            <?php if (isset($mensaje)) { ?>

                <div class="alert alert-danger">

                    <?= $mensaje; ?>

                </div>

            <?php } ?>

            <form method="POST">

                <div class="mb-3">

                    <label
                        class="form-label">

                        Nombre

                    </label>
<input
    type="text"
    name="nombre"
    class="form-control"
    required>

</div>
                <div class="mb-3">

                    <label
                        class="form-label">

                        Apellido

                    </label>

                    <input
                        type="text"
                        name="apellido"
                        class="form-control"
                        required>
                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    Guardar

                </button>

                <a
                    href="listar.php"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../js/script.js"></script>
</body>

</html>

<?php

$conexion->close();

?>