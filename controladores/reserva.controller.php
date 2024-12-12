<?php
include_once("../configuraciones/base_datos.php");
include_once("../utilidades/funciones.php");
include_once("../modelos/reserva.class.php");

class ReservaController {

    private $reserva;

    function __construct(){
        $this->reserva = new Reserva();  
    }

 function crearReserva($id_usuario, $id_alojamiento, $fecha_reserva, $fecha_ingreso, $fecha_salida){
        $resultado = $this->reserva->crearReserva($id_usuario, $id_alojamiento, $fecha_reserva, $fecha_ingreso, $fecha_salida);
        if ($resultado) {
            echo json_encode(array("estado" => "exito", "mensaje" => "Reserva creada con éxito"));
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "Hubo un error al crear la reserva"));
        }
    }

    function modificarReserva($id_reserva, $fecha_ingreso, $fecha_salida){
        $resultado = $this->reserva->modificarReserva($id_reserva, $fecha_ingreso, $fecha_salida);
        if ($resultado) {
            echo json_encode(array("estado" => "exito", "mensaje" => "Reserva modificada con éxito"));
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "Hubo un error al modificar la reserva"));
        }
    }

    function cancelarReserva($id_reserva){
        $resultado = $this->reserva->cancelarReserva($id_reserva);
        if ($resultado) {
            echo json_encode(array("estado" => "exito", "mensaje" => "Reserva cancelada con éxito"));
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "Hubo un error al cancelar la reserva"));
        }
    }

    function verHistorialReservas($id_usuario){
        $historial = $this->reserva->verHistorialReservas($id_usuario);
        if ($historial) {
            echo json_encode($historial);
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "No se encontraron reservas para este usuario"));
        }
    }

   /*
    function generarCodigoQR(){
        $codigoQR = $this->reserva-> generarCodigoQR();
        if ($codigoQR) {
            echo json_encode(array("estado" => "exito", "codigoQR" => $codigoQR));
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "Hubo un error al generar el código QR"));
        }
    }
*/
 /*
    function obtenerDetallesReserva($id_reserva){
        $detalles = $this->reserva->obtenerDetallesReserva($id_reserva);
        if ($detalles) {
            echo json_encode($detalles);
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "No se encontraron detalles para esta reserva"));
        }
    }

*/

}

$obj = new ReservaController();

$opcion = $_POST['opcion'];

switch($opcion){
    case "crear":
        header("content-type: application/json");
        $obj->crearReserva($_POST['id_usuario'], $_POST['id_alojamiento'], $_POST['fecha_reserva'], $_POST['fecha_ingreso'], $_POST['fecha_salida']);
        break;

    case "modificar":
        header("content-type: application/json");
        $obj->modificarReserva($_POST['id_reserva'], $_POST['fecha_ingreso'], $_POST['fecha_salida']);
        break;

    case "cancelar":
        header("content-type: application/json");
        $obj->cancelarReserva($_POST['id_reserva']);
        break;

    case "historial":
        header("content-type: application/json");
        $obj->verHistorialReservas($_POST['id_usuario']);
        break;

   /*case "generar_qr":
        header("content-type: application/json");
        $obj->generarCodigoQR();
        break;
*/
    case "detalles":
        header("content-type: application/json");
        $obj->obtenerDetallesReserva($_POST['id_reserva']);
        break;

    default:
        echo json_encode(array("estado" => "error", "mensaje" => "Opción no válida"));
        break;
}