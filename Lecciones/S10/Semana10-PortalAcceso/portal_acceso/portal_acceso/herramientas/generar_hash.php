<?php

$clave = $_GET['clave'] ?? '';

header('Content-type: text/html; charset = utf-8');

echo '<!DOCTYPE html> <html lang="es"> <head> <meta charset="utf-8">';
echo '<title> Generador de hash</title> </head> <body>';
echo '<h1>Generador de hash </h1>';

if($clave === ''){
    echo '<p> Agregue el parámetro de clave a la direccion </p>';
}else{
    $hash = password_hash($clave, PASSWORD_DEFAULT);
    echo '<p> Contraseña: <code>' . htmlspecialchars($clave, ENT_QUOTES, 'UTF-8') . '</code> </p>';
    echo '<p> Hash generado: </p>';
    echo '<textarea rows=4 cols=80>' . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . '</textarea>';
    echo '<p> longitud del hash: ' . strlen($hash) . ' caracteres. </p>';
}

echo '</body> </html>';