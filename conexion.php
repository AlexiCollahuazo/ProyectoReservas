<?php
    $ip = "127.0.0.1";
    $usuario = "root";
    $clave = "";
    $nombre_bd = "sistema_alojamiento";

// Crear la conexión
$conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>