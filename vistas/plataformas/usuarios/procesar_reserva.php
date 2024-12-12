<?php
include_once '../../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_espacio = $_POST['id_espacio'];
    $id_usuario = $_POST['id_usuario'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];  
    $observaciones = $_POST['observaciones'];

    $query = "INSERT INTO reservas (id_espacio, id_usuario, fecha_inicio, fecha_fin, estado, observaciones) 
              VALUES ('$id_espacio', '$id_usuario', '$fecha_inicio', '$fecha_fin', '$estado', '$observaciones')";

    if (mysqli_query($conexion, $query)) {
        echo "Reserva realizada con éxito";
    } else {

        echo "Error al realizar la reserva: " . mysqli_error($conexion);
    }
    mysqli_close($conexion);
}
?>