<?php

include_once("../configuraciones/base_datos.php");
include_once("../utilidades/funciones.php");
include_once("../modelos/usuario.class.php");

class UsuarioController{
    private $usuario;

    function __construct(){
        $this->usuario = new Usuario();
    }

    function obtenerRegistroPorId($id){
        echo json_encode($this->usuario->obtenerRegistroPorId($id));
    }

    function obtenerRegistros(){
        echo json_encode($this->usuario->obtenerRegistros());
    }

    function guardarUsuario($nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo){
        $resultado = $this->usuario->guardarUsuario($nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo);
        if($resultado){
            echo json_encode(array("estado" => "exito"));
        }else{
            echo json_encode(array("estado" => "error"));
        }
    }

    function editarUsuario($id, $nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo){
        $resultado = $this->usuario->actualizarUsuario($id, $nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo);
        if($resultado){
            echo json_encode(array("estado" => "exito"));
        }else{
            echo json_encode(array("estado" => "error"));
        }
    }

    function eliminarUsuario($id){
        $resultado = $this->usuario->eliminarUsuario($id);
        if($resultado){
            echo json_encode(array("estado" => "exito"));
        }else{
            echo json_encode(array("estado" => "error"));
        }
    }

    function validarAccesos($nombre_usuario, $clave){
        $resultado = $this->usuario->validarAccesos($nombre_usuario, $clave);
        if($resultado){
            echo json_encode(array("estado" => "exito"));
        }else{
            echo json_encode(array("estado" => "error"));
        }
       // $jwt = $this->usuario->validarAccesos($nombre_usuario, $clave);
       // return $jwt;
    }
    function validarLink($nombre_usuario, $clave){
        $resultado = $this->usuario->validarLink($nombre_usuario, $clave);
        if($resultado){
            echo json_encode(array("tipo" => "General"));
        }else{
            echo json_encode(array("tipo" => "General"));
        }
    }

}

$obj = new UsuarioController();
//$_POST['opcion'] = "validar_accesos";
//$_POST['nombre_usuario'] = "arodriguez";
//$_POST['clave'] = "1234";

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
            $obj->guardarUsuario($_POST['nombre'], $_POST['identificacion'], 
            $_POST['nombre_usuario'], $_POST['correo'], $_POST['clave'], $_POST['tipo']);
            break;
    case "editar":
            header("content-type: application/json");
            $obj->editarUsuario($_POST['id'], $_POST['nombre'], $_POST['identificacion'], 
            $_POST['nombre_usuario'], $_POST['correo'], $_POST['clave'], $_POST['tipo']);
            break;        
    case "eliminar":
        header("content-type: application/json");
        $obj->eliminarUsuario($_POST['id']);
        break;    
    case "validar_accesos":
        header("content-type: application/json");
        $obj->validarAccesos($_POST['nombre_usuario'], $_POST['clave']);
        break;
    case "validar_link":
        header("content-type: application/json");
        $obj->validarLink($_POST['nombre_usuario'], $_POST['clave']);
        break;

/*$jwt = $obj->validarAccesos($_POST['nombre_usuario'], $_POST['clave']);
        
        if ($jwt) {
           
            echo json_encode(array("estado" => "exito", "jwt" => $jwt));
        } else {
            echo json_encode(array("estado" => "error", "mensaje" => "Credenciales incorrectas"));
        }
        break; */    
}



