<?php
$logFile = "../../../logs/usuario.log";

if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);

} else {
    $logContent = 'No se encuentra el archivo de logs.';
}



$htmlContent = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs por Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .log-container {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            white-space: pre-wrap; /* Preserva los saltos de línea */
            max-width: 900px;
            margin: auto;
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>

    <h1>Logs de Usuario</h1>

    <div class="log-container">
        <pre>' . htmlspecialchars($logContent) . '</pre>
    </div>

</body>
</html>';

file_put_contents('logs_por_usuario.html', $htmlContent);

header('Location: logs/usuario.log');
exit;
?>
