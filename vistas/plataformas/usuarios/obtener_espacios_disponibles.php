<?php
include_once '../../../conexion.php'; 
$fechaSeleccionada = $_GET['fecha'] ?? date('Y-m-d');

$query = "
    SELECT e.id_espacio, e.nombre, e.descripcion, e.capacidad, e.imagen_url
    FROM espacios e
    LEFT JOIN reservas r ON e.id_espacio = r.id_espacio 
    AND ('$fechaSeleccionada' BETWEEN r.fecha_inicio AND r.fecha_fin)
    WHERE r.id_espacio IS NULL
";

$resultado = $conexion->query($query);

if ($resultado) {
    $espacios = array();

    while ($espacio = $resultado->fetch_assoc()) {
        $espacios[] = $espacio;
    }

    echo json_encode($espacios);
} else {
    echo json_encode(array('error' => 'No se pudo obtener los espacios disponibles.'));
}
?>
