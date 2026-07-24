<?php
declare(strict_types=1);

$clave = $_GET['clave'] ?? '';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generador de Hash</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f4f4f4; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 600px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 80px; font-family: monospace; }
        code { background: #eee; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Generador de Hash - PHP</h1>
        <?php if ($clave === ''): ?>
            <p>Pasa la contraseña por la URL. Ejemplo:</p>
            <p><code>http://localhost/tu_proyecto/generar_hash.php?clave=TuContrasena123</code></p>
        <?php else: ?>
            <?php $hash = password_hash($clave, PASSWORD_DEFAULT); ?>
            <p><strong>Contraseña ingresada:</strong> <code><?php echo htmlspecialchars($clave, ENT_QUOTES, 'UTF-8'); ?></code></p>
            <p><strong>Hash generado (PASSWORD_DEFAULT):</strong></p>
            <textarea readonly><?php echo htmlspecialchars($hash, ENT_QUOTES, 'UTF-8'); ?></textarea>
            <p><small>Longitud: <?php echo strlen($hash); ?> caracteres.</small></p>
        <?php endif; ?>
    </div>
</body>
</html>