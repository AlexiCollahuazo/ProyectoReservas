<?php
include_once("../configuraciones/base_datos.php");
include_once("../utilidades/funciones.php");
include_once("../modelos/alojamiento.class.php");

class AlojamientoController {

    private $alojamiento;

    function __construct(){

        $this->alojamiento = new Alojamiento();
    }


    function obtenerRegistroPorId($id){
        echo json_encode($this->alojamiento->obtenerRegistroPorId($id));
    }

 
    function obtenerRegistros(){
        echo json_encode($this->alojamiento->obtenerRegistros());
    }

    // Método para guardar un nuevo alojamiento
    function guardarAlojamiento($id_usuario, $descripcion, $ubicacion, $precio, $estado){
  
        $resultado = $this->alojamiento->guardarAlojamiento($id_usuario, $descripcion, $ubicacion, $precio, $estado);
        if ($resultado) {
            echo json_encode(array("estado" => "exito"));
        } else {
            echo json_encode(array("estado" => "error"));
        }
    }

    // Método para actualizar un alojamiento
    function actualizarAlojamiento($id, $id_usuario, $descripcion, $ubicacion, $precio, $estado){

        $resultado = $this->alojamiento->actualizarAlojamiento($id, $id_usuario, $descripcion, $ubicacion, $precio, $estado);
        if ($resultado) {
            echo json_encode(array("estado" => "exito"));
        } else {
            echo json_encode(array("estado" => "error"));
        }
    }

    function eliminarAlojamiento($id){
        $resultado = $this->alojamiento->eliminarAlojamiento($id);
        if ($resultado) {
            echo json_encode(array("estado" => "exito"));
        } else {
            echo json_encode(array("estado" => "error"));
        }
    }

 
    function eliminarAlojamientoLogico($id){
        $resultado = $this->alojamiento->eliminarAlojamientoLogico($id);
        if ($resultado) {
            echo json_encode(array("estado" => "exito"));
        } else {
            echo json_encode(array("estado" => "error"));
        }
    }

    function obtenerAlojamientosActivos(){
        echo json_encode($this->alojamiento->obtenerAlojamientosActivos());
    }
    function obtenerAlojamientosPorDescripcionOPrecio($descripcion = null, $precio = null){
        echo json_encode($this->alojamiento->obtenerAlojamientoPorDescripcionOPrecio($descripcion, $precio));
    }

}

$obj = new AlojamientoController();

$opcion = $_POST['opcion'];

switch($opcion){
    case "listado":
        header("content-type: application/json");
        $obj->obtenerRegistros();
        break;
    case "obtener_registro":
        header("content-type: application/json");
        $obj->obtenerRegistroPorId($_POST['id']);
        break;
    case "guardar":
        header("content-type: application/json");
        $obj->guardarAlojamiento($_POST['id_usuario'], $_POST['descripcion'], $_POST['ubicacion'], $_POST['precio'], $_POST['estado']);
        break;
    case "editar":
        header("content-type: application/json");
        $obj->actualizarAlojamiento($_POST['id'], $_POST['id_usuario'], $_POST['descripcion'], $_POST['ubicacion'], $_POST['precio'], $_POST['estado']);
        break;
    case "eliminar":
        header("content-type: application/json");
        $obj->eliminarAlojamiento($_POST['id']);
        break;
    case "eliminar_logico":
        header("content-type: application/json");
        $obj->eliminarAlojamientoLogico($_POST['id']);
        break;
    case "obtener_por_descripcion_o_precio":
        header("content-type: application/json");
        $obj->obtenerAlojamientosPorDescripcionOPrecio($_POST['descripcion'], $_POST['precio']);
        break;
    case "obtener_activos":
        header("content-type: application/json");
        $obj->obtenerAlojamientosActivos();
        break;
    default:
        echo json_encode(array("estado" => "error", "mensaje" => "Error:V"));
        break;
}

