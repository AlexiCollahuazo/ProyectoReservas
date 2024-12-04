
<?php
include_once("../configuraciones/base_datos.php");
include_once("../utilidades/funciones.php");
include_once("../modelos/administrador.class.php");

class AdministradorController {

    private $administrador;

    // Constructor que inicializa la clase Administrador
    function __construct(){
        $this->administrador = new Administrador();  // Instancia de la clase Administrador
    }

    // Método para ver estadísticas del sistema
    function verEstadisticas(){
        echo json_encode($this->administrador->verEstadisticas());
    }

    // Método para gestionar usuarios
    function gestionarUsuarios(){
        echo json_encode($this->administrador->gestionarUsuarios());
    }

    // Método para gestionar alojamientos
    function gestionarAlojamientos(){
        echo json_encode($this->administrador->gestionarAlojamientos());
    }

    // Método para ver historial de reservas
    function verHistorialReservas(){
        echo json_encode($this->administrador->verHistorialReservas());
    }
}

$obj = new AdministradorController();

// Obtener la opción de la petición (por ejemplo, desde un formulario o API)
$opcion = $_POST['opcion'];

// Definir los casos disponibles
switch($opcion){
    case "estadisticas":
        header("content-type: application/json");
        $obj->verEstadisticas();
        break;

    case "usuarios":
        header("content-type: application/json");
        $obj->gestionarUsuarios();
        break;

    case "alojamientos":
        header("content-type: application/json");
        $obj->gestionarAlojamientos();
        break;

    case "historial":
        header("content-type: application/json");
        $obj->verHistorialReservas();
        break;

    default:
        echo json_encode(array("estado" => "error", "mensaje" => "Opción no válida"));
        break;
}