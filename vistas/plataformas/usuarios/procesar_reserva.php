<?php

include_once '../../../conexion.php';
require '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        $id_reserva = mysqli_insert_id($conexion);
        $query_usuario = "SELECT correo FROM usuarios WHERE id_usuario = '$id_usuario'";
        $result = mysqli_query($conexion, $query_usuario);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];


        enviarCorreoConDetalles($email, $id_reserva, $id_espacio, $fecha_inicio, $fecha_fin);


    } else {
        echo "Error al realizar la reserva: " . mysqli_error($conexion);
    }
    mysqli_close($conexion);
}


function enviarCorreoConDetalles($email, $id_reserva, $id_espacio, $fecha_inicio, $fecha_fin) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                           
        $mail->Host       = 'sandbox.smtp.mailtrap.io';                       
        $mail->SMTPAuth   = true;                                    
        $mail->Username   = '03d058af084204';                          
        $mail->Password   = '3829c0bb94e4b1';                          
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                   
        
        $mail->setFrom('no-reply@tusitio.com', 'Sistema de Reservas');
        $mail->addAddress($email);                                 

        $mail->Subject = "Confirmación de Reserva";
        $mail->Body    = "¡Gracias por tu reserva! Aquí están los detalles de tu reserva:\n\n" .
                         "ID de Reserva: $id_reserva\n" .
                         "Espacio Reservado: $id_espacio\n" .
                         "Fecha de Inicio: $fecha_inicio\n" .
                         "Fecha de Fin: $fecha_fin\n\n" ;
        $mail->send();
        echo 'Correo enviado';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>