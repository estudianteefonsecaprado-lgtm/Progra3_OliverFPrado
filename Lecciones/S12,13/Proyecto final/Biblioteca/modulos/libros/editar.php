<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: editar.php
 * Descripción:
 * Permite editar la información de un libro.
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

// ============================================================
// Verificar permisos de administrador
// ============================================================

if ($_SESSION["rol"] != "Administrador") {

    redireccionar("../../inicio.php");

}

// ============================================================
// Obtener el ID del libro
// ============================================================

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

/*============================================================
Consultar la información del libro
============================================================*/

$sql = "SELECT * FROM libros WHERE id_libro = ?";

$consulta = $conexion->prepare($sql);

$consulta->bind_param("i", $id);

$consulta->execute();

$libro = $consulta->get_result()->fetch_assoc();

/*============================================================
Consultar autores registrados
============================================================*/

$autores = $conexion->query(
    "SELECT * FROM autores ORDER BY apellido, nombre"
);

/*============================================================
Consultar categorías registradas
============================================================*/

$categorias = $conexion->query(
    "SELECT * FROM categorias ORDER BY nombre"
);

/*============================================================
Actualizar libro
============================================================*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener datos enviados por el formulario

    $id = (int) $_POST["id"];
    $titulo = limpiarTexto($_POST["titulo"]);
    $anio = (int) $_POST["anio"];
    $idAutor = (int) $_POST["id_autor"];
    $idCategoria = (int) $_POST["id_categoria"];
    $disponible = isset($_POST["disponible"]) ? 1 : 0;

    // Conservar la portada actual si no se reemplaza

    $nombreImagen = $_POST["imagen_actual"];

    /*========================================================
    Procesar una nueva imagen de portada
    ========================================================*/

    if (!empty($_FILES["imagen"]["name"])) {

        // Eliminar la imagen anterior

        if (
            !empty($nombreImagen) &&
            file_exists("../../imagenes/portadas/" . $nombreImagen)
        ) {

            unlink("../../imagenes/portadas/" . $nombreImagen);

        }

        // Generar un nombre único para la nueva imagen

        $extension = pathinfo(
            $_FILES["imagen"]["name"],
            PATHINFO_EXTENSION
        );

        $nombreImagen = time() . "." . $extension;

        // Guardar la nueva imagen

        move_uploaded_file(
            $_FILES["imagen"]["tmp_name"],
            "../../imagenes/portadas/" . $nombreImagen
        );

    }

    /*========================================================
    Actualizar el registro del libro
    ========================================================*/

    $sql = "UPDATE libros
            SET titulo = ?,
                anio = ?,
                imagen = ?,
                disponible = ?,
                id_autor = ?,
                id_categoria = ?
            WHERE id_libro = ?";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param(
        "sisiiii",
        $titulo,
        $anio,
        $nombreImagen,
        $disponible,
        $idAutor,
        $idCategoria,
        $id
    );

    if ($consulta->execute()) {

        redireccionar("listar.php");

    } else {

        $mensaje = "No fue posible actualizar el libro.";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ======================================================
         Configuración del documento
    ======================================================= -->

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Editar libro</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Hoja de estilos personalizada -->

    <link rel="stylesheet" href="../../css/estilos.css">

</head>

<body>

<!-- ==========================================================
     Contenedor principal
=========================================================== -->

<div class="container mt-5">

    <!-- Tarjeta del formulario -->

    <div class="card shadow">

        <!-- Encabezado -->

        <div class="card-header card-header-personalizado">

            <h3>

                Editar libro

            </h3>

        </div>

        <div class="card-body">

            <!-- Mostrar mensaje de error -->

            <?php if (isset($mensaje)) { ?>

                <div class="alert alert-danger">

                    <?= $mensaje ?>

                </div>

            <?php } ?>

            <!-- Formulario para editar el libro -->

            <form
                method="POST"
                enctype="multipart/form-data">

                <!-- Identificador oculto del libro -->

                <input
                    type="hidden"
                    name="id"
                    value="<?= $libro["id_libro"] ?>">

                <!-- Guardar el nombre de la portada actual -->

                <input
                    type="hidden"
                    name="imagen_actual"
                    value="<?= $libro["imagen"] ?>">

                <!-- Campo: Título -->

                <div class="mb-3">

                    <label class="form-label">

                        Título

                    </label>

                    <input
                        type="text"
                        name="titulo"
                        class="form-control"
                        value="<?= $libro["titulo"] ?>"
                        required>

                </div>

                <!-- Campo: Año -->

                <div class="mb-3">

                    <label class="form-label">

                        Año

                    </label>

                    <input
                        type="number"
                        name="anio"
                        class="form-control"
                        value="<?= $libro["anio"] ?>"
                        required>

                </div>

                <!-- Selección del autor -->

                <div class="mb-3">

                    <label class="form-label">

                        Autor

                    </label>

                    <select
                        name="id_autor"
                        class="form-select">

                        <?php while ($autor = $autores->fetch_assoc()) { ?>

                            <option
                                value="<?= $autor["id_autor"] ?>"
                                <?= $autor["id_autor"] == $libro["id_autor"] ? "selected" : "" ?>>

                                <?= $autor["nombre"] ?>
                                <?= $autor["apellido"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Selección de la categoría -->

                <div class="mb-3">

                    <label class="form-label">

                        Categoría

                    </label>

                    <select
                        name="id_categoria"
                        class="form-select">

                        <?php while ($categoria = $categorias->fetch_assoc()) { ?>

                            <option
                                value="<?= $categoria["id_categoria"] ?>"
                                <?= $categoria["id_categoria"] == $libro["id_categoria"] ? "selected" : "" ?>>

                                <?= $categoria["nombre"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Cargar una nueva portada -->

                <div class="mb-3">

                    <label class="form-label">

                        Cambiar portada

                    </label>

                    <input
                        type="file"
                        name="imagen"
                        class="form-control"
                        accept="image/*">

                </div>

                <!-- Estado de disponibilidad -->

                <div class="form-check mb-4">

                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="disponible"
                        <?= $libro["disponible"] ? "checked" : "" ?>>

                    <label class="form-check-label">

                        Disponible

                    </label>

                </div>

                <!-- Botones de acción -->

                <button
                    type="submit"
                    class="btn btn-warning">

                    Actualizar

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

<!-- Bootstrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript del proyecto -->

<script src="../../js/script.js"></script>

</body>

</html>

<?php

// ============================================================
// Cerrar conexión con la base de datos
// ============================================================

$conexion->close();

?>