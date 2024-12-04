<?php

class Alojamiento
{
    //Declaracion de nuestras variables
    private $id;
    private $id_usuario;
    private $descripcion;
    private $ubicacion;
    private $precio;
    private $estado;
    private $conexion;

    //Metodo que se llama al crar el objeto
function __construct(){
        global $ip, $usuario, $clave, $nombre_bd;
        $this->conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);
        if($this->conexion->connect_errno){
            echo "Error: ".$this->conexion->connect_errno;
        }
    }

    public function guardarAlojamiento($id_usuario, $descripcion, $ubicacion, $precio, $estado)
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "INSERT INTO alojamientos (id_usuario, descripcion, ubicacion, precio, estado) 
        VALUES ('$id_usuario','$descripcion','$ubicacion',' $precio','$estado')";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }

    public function actualizarAlojamiento($id, $id_usuario, $descripcion, $ubicacion, $precio, $estado)
    {
       
        $sql = "UPDATE alojamiento SET 
                    id_usuario = '$id_usuario', 
                    descripcion = '$descripcion', 
                    ubicacion = '$ubicacion', 
                    precio = '$precio', 
                    estado = '$estado' 
                WHERE id = '$id'";

        try {
           
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
           
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }


    //Hard delete
    public function eliminarAlojamiento($id)
    {
        // Conectarnos a la base de datos
        $sql = "DELETE FROM alojamiento WHERE id = '$id'";

        try {
        
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
  
            guardarLog("alojamiento.log", $e->getMessage());
            return false;
        }
    }

    //Soft delete
    public function eliminarAlojamientoLogico($id)
    {

    $sql = "UPDATE alojamiento SET estado = '0' WHERE id = '$id'";

    try {
        
        $this->conexion->query($sql);
        return true;
    } catch (Exception $e) {
        // Si hay un error, lo registramos en el log
        guardarLog("alojamiento.log", $e->getMessage());
        return false;
    }
    }


    function obtenerRegistros()
    {
        $arreglo = [];
        $sql = "SELECT * FROM alojamiento";
        
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


   function obtenerRegistroPorId($id)
    {
        $arreglo = [];
        $sql = "SELECT * FROM alojamiento WHERE id = '$id'";

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
    }


// Revisar este metodo porque ando suponiento que los activos son los que tienen 1:v
    function obtenerAlojamientosActivos()
    {
        $arreglo = [];
        $sql = "SELECT * FROM alojamiento WHERE estado = 1"; 
        
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

    
}
