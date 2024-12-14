<?php
// Incluir la configuración de la base de datos
include(/conexion.php');

// Obtener estadísticas de las reservaciones
$sql_reservas = "SELECT estado, COUNT(*) as count FROM reservas GROUP BY estado";
$result_reservas = $conn->query($sql_reservas);
$reservas = [];
while ($row = $result_reservas->fetch_assoc()) {
    $reservas[$row['estado']] = $row['count'];
}

// Obtener estadísticas de usuarios por tipo
$sql_usuarios = "SELECT tipo, COUNT(*) as count FROM usuarios GROUP BY tipo";
$result_usuarios = $conn->query($sql_usuarios);
$usuarios = [];
while ($row = $result_usuarios->fetch_assoc()) {
    $usuarios[$row['tipo']] = $row['count'];
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas del Sistema de Alojamiento</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Estadísticas del Sistema de Alojamiento</h1>
    
    <h2>Estado de las Reservaciones</h2>
    <canvas id="reservasChart" width="400" height="200"></canvas>

    <h2>Usuarios por Tipo</h2>
    <canvas id="usuariosChart" width="400" height="200"></canvas>

    <script>
        // Datos de las reservaciones
        var reservasData = <?php echo json_encode($reservas); ?>;
        var reservasLabels = ['ACTIVA', 'CANCELADA'];
        var reservasCounts = [reservasData['ACTIVA'] || 0, reservasData['CANCELADA'] || 0];

        var ctx = document.getElementById('reservasChart').getContext('2d');
        var reservasChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: reservasLabels,
                datasets: [{
                    label: 'Estado de las Reservaciones',
                    data: reservasCounts,
                    backgroundColor: ['#36A2EB', '#FF6384'],
                    hoverOffset: 4
                }]
            }
        });

        // Datos de los usuarios
        var usuariosData = <?php echo json_encode($usuarios); ?>;
        var usuariosLabels = ['Administrador', 'General'];
        var usuariosCounts = [usuariosData['Administrador'] || 0, usuariosData['General'] || 0];

        var ctx2 = document.getElementById('usuariosChart').getContext('2d');
        var usuariosChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: usuariosLabels,
                datasets: [{
                    label: 'Usuarios por Tipo',
                    data: usuariosCounts,
                    backgroundColor: '#FFCD56',
                    borderColor: '#FFCD56',
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>
