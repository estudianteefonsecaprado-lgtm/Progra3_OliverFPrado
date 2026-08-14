<?php

/**
 * ============================================================
 * Proyecto Final - Programación III
 * Sistema de Gestión de Biblioteca
 * ------------------------------------------------------------
 * Archivo: listar.php
 * Descripción:
 * Muestra el listado de libros registrados.
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
// Obtener el texto de búsqueda
// ============================================================

$buscar = "";

if (isset($_GET["buscar"])) {

    $buscar = limpiarTexto($_GET["buscar"]);

}

// ============================================================
// Consultar libros según el criterio de búsqueda
// ============================================================

if ($buscar != "") {

    $sql = "SELECT

                libros.*,

                autores.nombre AS nombre_autor,
                autores.apellido,

                categorias.nombre AS categoria

            FROM libros

            INNER JOIN autores
                ON libros.id_autor = autores.id_autor

            INNER JOIN categorias
                ON libros.id_categoria = categorias.id_categoria

            WHERE

                libros.titulo LIKE ?

                OR CONCAT(autores.nombre, ' ', autores.apellido) LIKE ?

                OR categorias.nombre LIKE ?

            ORDER BY libros.titulo ASC";

    $stmt = $conexion->prepare($sql);

    // Preparar el texto para realizar la búsqueda parcial

    $textoBusqueda = "%" . $buscar . "%";

    $stmt->bind_param(

        "sss",

        $textoBusqueda,

        $textoBusqueda,

        $textoBusqueda

    );

    $stmt->execute();

    $resultado = $stmt->get_result();

} else {

    // ========================================================
    // Mostrar todos los libros registrados
    // ========================================================

    $sql = "SELECT

                libros.*,

                autores.nombre AS nombre_autor,
                autores.apellido,

                categorias.nombre AS categoria

            FROM libros

            INNER JOIN autores
                ON libros.id_autor = autores.id_autor

            INNER JOIN categorias
                ON libros.id_categoria = categorias.id_categoria

            ORDER BY libros.titulo ASC";

    $resultado = $conexion->query($sql);

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

    <title>Libros</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Hoja de estilos personalizada -->

    <link rel="stylesheet" href="../../css/estilos.css">

</head>

<body>

<!-- ==========================================================
     Contenedor principal
=========================================================== -->

<div class="container mt-5">

    <!-- Encabezado del módulo -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            Libros

        </h2>

        <!-- Botón para registrar un nuevo libro -->

        <a
            href="agregar.php"
            class="btn btn-success">

            <i class="bi bi-plus-circle"></i>

            Agregar libro

        </a>

    </div>

    <!-- =======================================================
         Formulario de búsqueda
    ======================================================== -->

    <div class="row mb-4">

        <div class="col-md-6">

            <form method="GET">

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>

                    <input
                        type="text"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar por título, autor o categoría..."
                        value="<?= isset($_GET["buscar"]) ? htmlspecialchars($_GET["buscar"]) : ""; ?>">

                    <button
                        type="submit"
                        class="btn btn-libros">

                        Buscar

                    </button>

                </div>

            </form>

        </div>

    </div>

    <!-- =======================================================
         Tabla con el listado de libros
    ======================================================== -->

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>Portada</th>

                <th>Título</th>

                <th>Año</th>

                <th>Autor</th>

                <th>Categoría</th>

                <th>Disponible</th>

                <th class="text-center">

                    Acciones

                </th>

            </tr>

        </thead>

        <tbody>

        <!-- Recorrer todos los libros obtenidos de la base de datos -->

        <?php while ($libro = $resultado->fetch_assoc()) { ?>

            <tr>

                <!-- Mostrar la portada del libro -->

                <td>

                    <img
                        src="../../imagenes/portadas/<?= $libro["imagen"]; ?>"
                        class="img-portada"
                        alt="Portada">

                </td>

                <!-- Información del libro -->

                <td>

                    <?= $libro["titulo"]; ?>

                </td>

                <td>

                    <?= $libro["anio"]; ?>

                </td>

                <td>

                    <?= $libro["nombre_autor"]; ?>

                    <?= $libro["apellido"]; ?>

                </td>

                <td>

                    <?= $libro["categoria"]; ?>

                </td>

                <!-- Mostrar el estado de disponibilidad -->

                <td>

                    <?= $libro["disponible"] ? "Sí" : "No"; ?>

                </td>

                <!-- Botones para editar o eliminar el libro -->

                <td class="text-center">

                    <a
                        href="editar.php?id=<?= $libro["id_libro"]; ?>"
                        class="btn btn-warning btn-sm me-2">

                        Editar

                    </a>

                    <a
                        href="eliminar.php?id=<?= $libro["id_libro"]; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Desea eliminar este libro?');">

                        Eliminar

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <!-- Botón para regresar al menú principal -->

    <a
        href="../../inicio.php"
        class="btn btn-secondary">

        Volver

    </a>

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