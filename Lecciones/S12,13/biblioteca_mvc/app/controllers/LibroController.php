<?php

class LibroController
{
    public function __construct(private Libro $modelo)
    {
    }

    public function procesar(): void
    {
        $accion = $_GET['accion'] ?? 'listar';

        switch ($accion) {
            case 'crear':
                $this->crear();
                break;

            case 'editar':
                $this->editar();
                break;

            case 'eliminar':
                $this->eliminar();
                break;

            default:
                $this->listar();
                break;
        }
    }

    private function listar(): void
    {
        $genero = $_GET['genero'] ?? '';

        if ($genero !== '') {
            $libros = $this->modelo->obtenerPorGenero($genero);
        } else {
            $libros = $this->modelo->obtenerTodos();
        }

        $resumen = $this->modelo->obtenerResumen();
        $generos = $this->modelo->obtenerGeneros();

        require '../app/views/layouts/header.php';
        require '../app/views/libros/lista.php';
        require '../app/views/layouts/footer.php';
    }

    private function crear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = [
                'titulo' => trim($_POST['titulo']),
                'autor' => trim($_POST['autor']),
                'anio_publicacion' => $_POST['anio_publicacion'],
                'genero' => $_POST['genero'],
                'isbn' => trim($_POST['isbn']),
                'disponible' => $_POST['disponible']
            ];

            $this->modelo->crear($datos);

            header('Location: index.php');
            exit;
        }

        $libro = null;

        require '../app/views/layouts/header.php';
        require '../app/views/libros/formulario.php';
        require '../app/views/layouts/footer.php';
    }

    private function editar(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $datos = [
                'titulo' => trim($_POST['titulo']),
                'autor' => trim($_POST['autor']),
                'anio_publicacion' => $_POST['anio_publicacion'],
                'genero' => $_POST['genero'],
                'isbn' => trim($_POST['isbn']),
                'disponible' => $_POST['disponible']
            ];

            $this->modelo->actualizar($id, $datos);

            header('Location: index.php');
            exit;
        }

        $libro = $this->modelo->obtenerPorId($id);

        require '../app/views/layouts/header.php';
        require '../app/views/libros/formulario.php';
        require '../app/views/layouts/footer.php';
    }

    private function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

            if ($id) {
                $this->modelo->eliminar($id);
            }
        }

        header('Location: index.php');
        exit;
    }
}