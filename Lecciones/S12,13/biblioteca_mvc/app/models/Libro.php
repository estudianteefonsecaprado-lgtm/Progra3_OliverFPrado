<?php

class Libro
{
    public function __construct(private PDO $pdo)
    {
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM libros ORDER BY titulo";

        $consulta = $this->pdo->query($sql);

        return $consulta->fetchAll();
    }

    public function obtenerPorGenero(string $genero): array
    {
        $sql = "SELECT * FROM libros
                WHERE genero = ?
                ORDER BY titulo";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$genero]);

        return $consulta->fetchAll();
    }

    public function obtenerPorId(int $id): array|false
    {
        $sql = "SELECT * FROM libros WHERE id = ?";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$id]);

        return $consulta->fetch();
    }

    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO libros
                (titulo, autor, anio_publicacion, genero, isbn, disponible)
                VALUES (?, ?, ?, ?, ?, ?)";

        $consulta = $this->pdo->prepare($sql);

        return $consulta->execute([
            $datos['titulo'],
            $datos['autor'],
            $datos['anio_publicacion'],
            $datos['genero'],
            $datos['isbn'],
            $datos['disponible']
        ]);
    }

    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE libros
                SET titulo = ?,
                    autor = ?,
                    anio_publicacion = ?,
                    genero = ?,
                    isbn = ?,
                    disponible = ?
                WHERE id = ?";

        $consulta = $this->pdo->prepare($sql);

        return $consulta->execute([
            $datos['titulo'],
            $datos['autor'],
            $datos['anio_publicacion'],
            $datos['genero'],
            $datos['isbn'],
            $datos['disponible'],
            $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM libros WHERE id = ?";

        $consulta = $this->pdo->prepare($sql);

        return $consulta->execute([$id]);
    }

    public function obtenerResumen(): array
    {
        $sql = "SELECT
                    COUNT(*) AS total,
                    SUM(disponible = 1) AS disponibles,
                    SUM(disponible = 0) AS no_disponibles
                FROM libros";

        $consulta = $this->pdo->query($sql);

        return $consulta->fetch();
    }

    public function obtenerGeneros(): array
    {
        $sql = "SELECT DISTINCT genero
                FROM libros
                ORDER BY genero";

        $consulta = $this->pdo->query($sql);

        return $consulta->fetchAll();
    }
}