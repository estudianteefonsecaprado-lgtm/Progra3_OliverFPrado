<?php
namespace App\Config;

use PDO;

final class Database
{
    private static ?PDO $conexion = null;

    private function __construct()
    {
    }

    public static function obtenerConexion() : PDO{
        if(self::$conexion == null){
            $host = self::variable('DB_HOST', 'localhost');
            $puerto = self::variable('DB_PORT', '3306');
            $nombre = self::variable('DB_NAME', 'gestor_incidencias');
            $usuario = self::variable('DB_USER', 'root');
            $clave = self::variable('DB_PASS', '');

            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $host, $puerto, $nombre
            );

            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            self::$conexion = new PDO($dsn, $usuario, $clave, $opciones);
        }
        return self::$conexion;
    }

       private static function variable(string $nombre, string $predeterminado): string{
        $valor = getenv($nombre);
        return $valor === false ? $predeterminado : $valor;
}

}
?>