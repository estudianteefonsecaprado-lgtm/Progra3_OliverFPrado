<?php

class Database
{
    private string $host = "localhost";
    private string $db = "biblioteca_db";
    private string $user = "root";
    private string $pass = "";
    private string $charset = "utf8mb4";

    public function conectar(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";

        try {
            $pdo = new PDO($dsn, $this->user, $this->pass);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;

        } catch (PDOException $e) {
            die("Error al conectar con la base de datos.");
        }
    }
}

