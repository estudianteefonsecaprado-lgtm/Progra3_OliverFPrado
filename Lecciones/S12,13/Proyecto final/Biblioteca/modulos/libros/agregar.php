<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: agregar.php
 * Descripción:
 * Permite registrar un nuevo libro.
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
// Consultar autores registrados
// ============================================================

$autores = $conexion->query(
    "SELECT * FROM autores ORDER BY apellido, nombre"
);

// ============================================================
// Consultar categorías registradas
// ============================================================

$categorias = $conexion->query(
    "SELECT * FROM categorias ORDER BY nombre"
);

// ============================================================
// Guardar libro
// ============================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = limpiarTexto($_POST["titulo"]);
    $anio = (int) $_POST["anio"];
    $idAutor = (int) $_POST["id_autor"];
    $idCategoria = (int) $_POST["id_categoria"];

    $disponible = isset($_POST["disponible"]) ? 1 : 0;

    // ========================================================
    // Procesar la imagen de portada
    // ========================================================

    $nombreImagen = "";

    if (!empty($_FILES["imagen"]["name"])) {

        $extension = pathinfo(
            $_FILES["imagen"]["name"],
            PATHINFO_EXTENSION
        );

        $nombreImagen = time() . "." . $extension;

        move_uploaded_file(

            $_FILES["imagen"]["tmp_name"],

            "../../imagenes/portadas/" . $nombreImagen

        );

    }

    // ========================================================
    // Insertar el libro en la base de datos
    // ========================================================

    $sql = "INSERT INTO libros
            (titulo, anio, imagen, disponible,
            id_autor, id_categoria)
            VALUES (?, ?, ?, ?, ?, ?)";

    $consulta = $conexion->prepare($sql);

    $consulta->bind_param(

        "sisiii",

        $titulo,
        $anio,
        $nombreImagen,
        $disponible,
        $idAutor,
        $idCategoria

    );

    if ($consulta->execute()) {

        redireccionar("listar.php");

    } else {

        $mensaje = "No fue posible guardar el libro.";

    }

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<!-- ======================================================
     Configuración del documento
====================================================== -->

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Agregar libro</title>

<!-- Bootstrap -->

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
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

                Agregar libro

            </h3>

        </div>

        <div class="card-body">

            <!-- Mostrar mensaje de error -->

            <?php if(isset($mensaje)){ ?>

                <div class="alert alert-danger">

                    <?= $mensaje ?>

                </div>

            <?php } ?>

            <!-- Formulario para registrar un libro -->

            <form
                method="POST"
                enctype="multipart/form-data">

                <!-- Campo: Título -->

                <div class="mb-3">

                    <label>

                        Título

                    </label>

                    <input
                        type="text"
                        name="titulo"
                        class="form-control"
                        required>

                </div>

                <!-- Campo: Año de publicación -->

                <div class="mb-3">

                    <label>

                        Año

                    </label>

                    <input
                        type="number"
                        name="anio"
                        class="form-control"
                        required>

                </div>

                <!-- Selección del autor -->

                <div class="mb-3">

                    <label>

                        Autor

                    </label>

                    <select
                        name="id_autor"
                        class="form-select"
                        required>

                        <?php while($autor = $autores->fetch_assoc()){ ?>

                            <option
                                value="<?= $autor["id_autor"] ?>">

                                <?= $autor["nombre"] ?>

                                <?= $autor["apellido"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Selección de la categoría -->

                <div class="mb-3">

                    <label>

                        Categoría

                    </label>

                    <select
                        name="id_categoria"
                        class="form-select"
                        required>

                        <?php while($categoria = $categorias->fetch_assoc()){ ?>

                            <option
                                value="<?= $categoria["id_categoria"] ?>">

                                <?= $categoria["nombre"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Cargar imagen de portada -->

                <div class="mb-3">

                    <label>

                        Portada

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
                        name="disponible"
                        class="form-check-input"
                        checked>

                    <label
                        class="form-check-label">

                        Disponible

                    </label>

                </div>

                <!-- Botones de acción -->

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