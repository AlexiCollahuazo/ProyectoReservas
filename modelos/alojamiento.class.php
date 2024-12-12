<?php

class Alojamiento
{
    //Declaracion de nuestras variables
    private $id_espacio;
    private $nombre;
    private $descripcion;
    private $capacidad;
    private $estado;
    private $imagen;
    private $precio_noche;
    private $conexion;

    //Metodo que se llama al crar el objeto
function __construct(){
        global $ip, $usuario, $clave, $nombre_bd;
        $this->conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);
        if($this->conexion->connect_errno){
            echo "Error: ".$this->conexion->connect_errno;
        }
    }

    public function guardarAlojamiento($nombre, $descripcion, $capacidad, $precio_noche, $imagen_url)
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "INSERT INTO espacios (nombre, descripcion, capacidad, precio_noche, imagen_url) 
        VALUES ('$nombre', '$descripcion', '$capacidad','$precio_noche', '$imagen_url')";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }

    public function actualizarAlojamiento($id_espacio, $nombre, $descripcion, $capacidad, $precio_noche)
    {
        $sql = "UPDATE espacios SET id_espacio ='$id_espacio', nombre='$nombre', descripcion='$descripcion', capacidad='$capacidad', precio_noche='$precio_noche' WHERE id_espacio = '$id_espacio'";

        try {
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
           
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }


    //Hard delete
    public function eliminarAlojamiento($id_espacio)
    {
        $sql = "DELETE FROM espacios WHERE id_espacio = '$id_espacio'";
        try {
        
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
  
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }

    //Soft delete
    public function eliminarAlojamientoLogico($id_espacio)
    {

    $sql = "UPDATE espacios SET estado = '0' WHERE id_espacio = '$id_espacio'";

    try {
        
        $this->conexion->query($sql);
        return true;
    } catch (Exception $e) {
        // Si hay un error, lo registramos en el log
        guardarLog("alojamiento.log", $e->getMessage());
        return false;
    }
    }


    public function obtenerRegistros()
    {
        $arreglo = [];
        $sql = "SELECT * FROM espacios";
        
        try {
            
            $resultados = $this->conexion->query($sql);
          
            while ($fila = $resultados->fetch_assoc()) {
                $arreglo[] = $fila; 
            }

            return $arreglo;
        } catch (Exception $e) {
            
            guardarLog("alojamiento.log", $e->getMessage());
            return $arreglo; 
        }
    }


   function obtenerRegistroPorId($id_espacio)
    {
        $arreglo = [];
        $sql = "SELECT * FROM espacios WHERE id_espacio = '$id_espacio'";

        try {
        
            $resultados = $this->conexion->query($sql);
            
        
            if ($fila = $resultados->fetch_assoc()) {
                $arreglo = $fila; 
            }

            return $arreglo;
        } catch (Exception $e) {
        
            guardarLog("alojamiento.log", $e->getMessage());
            return $arreglo; 
        }
    }

// Revisar este metodo porque ando suponiento que los activos son los que tienen 1:v
    function obtenerAlojamientosActivos()
    {
        $arreglo = [];
        $sql = "SELECT * FROM espacios WHERE estado = 1"; 
        
        try {
            $resultados = $this->conexion->query($sql);
        
            while ($fila = $resultados->fetch_assoc()) {
                $arreglo[] = $fila; 
            }
            return $arreglo;
        } catch (Exception $e) {
            guardarLog("alojamiento.log", $e->getMessage());
            return $arreglo;
        }
    }
/*
    function obtenerAlojamientoPorDescripcionOPrecio($descripcion, $precio)
    {
        $sql = "SELECT * FROM alojamiento WHERE descripcion = '$descripcion' AND precio = '$precio'";

        try {
            $resultados = $this->conexion->query($sql);

            if ($resultados->num_rows > 0) {
                return true;
            } else {
                return false; 
            }

        } catch (Exception $e) {

            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }*/

}