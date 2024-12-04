<?php

class Usuario
{
    //Declaracion de nuestras variables
    private $id;
    private $nombre;
    private $identificacion;
    private $nombre_usuario;
    private $correo;
    private $clave;
    private $estado;
    private $tipo;
    private $conexion;

    //Metodo que se llama al crar el objeto
    function __construct(){
        global $ip, $usuario, $clave, $nombre_bd;
        $this->conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);
        if($this->conexion->connect_errno){
            echo "Error: ".$this->conexion->connect_errno;
        }
    }

    //Accesors -> Getters ans setters
    public function obtenerNombre()
    {
        return $this->nombre;
    }

    public function colocarNombre($p_nombre)
    {
        $this->nombre = $p_nombre;
    }

    //Método
    public function obtenerInformacion($nombre)
    {
        echo "El nombre es " . $nombre;
        echo "<br>";
        echo "El nombre es " . $this->nombre;
    }

    //CRUD Create - Read - Update - Delete 

    public function guardarUsuario($nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo = 'GENERAL')
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "INSERT INTO usuarios (identificacion, nombre, nombre_usuario, clave, correo, tipo) 
        VALUES ('$identificacion','$nombre','$nombre_usuario',' $clave','$correo', '$tipo')";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
    }

    public function actualizarUsuario($id, $nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo = 'GENERAL')
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "UPDATE usuarios SET  nombre = '$nombre', identificacion = '$identificacion',
        nombre_usuario = '$nombre_usuario', correo = '$correo', clave = '$clave', tipo = '$tipo'
        WHERE id = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
        
    }

    //Hard delete
    public function eliminarUsuario($id)
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "DELETE FROM usuarios WHERE id = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
        
    }

    //Soft delete
    public function eliminarUsuarioLogico($id)
    {
        //El id se genera y el estado será 1 por defecto
        //Conectarnos a base de datos
        $sql = "UPDATE usuarios SET estado = '0' WHERE id = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
        
    }


    function obtenerRegistros(){
        $arreglo = [];
        $sql = "SELECT * FROM usuarios";
        try{
            $resultados = $this->conexion->query($sql);
            while($fila = $resultados->fetch_assoc()){
                $arreglo[] = $fila; //Nuevo elemento
            }
            return $arreglo;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return $arreglo;
        }
    }

    function obtenerRegistroPorId($id){
        $arreglo = [];
        $sql = "SELECT * FROM usuarios WHERE id = '$id'";
        try{
            $resultados = $this->conexion->query($sql);
            while($fila = $resultados->fetch_assoc()){
                $arreglo = $fila; //Nuevo elemento
            }
            return $arreglo;
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
            return $arreglo;
        }
    }

    function validarAccesos($nombre_usuario, $clave){
        
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND clave = '$clave'";
        try{
            $resultados = $this->conexion->query($sql);
            if($resultados->num_rows>0){
                return true;
            }else{
                return false;
            }
            
        }catch(Exception $e){
            //echo "El error es ".$e->getMessage();
            guardarLog("usuario.log", $e->getMessage());
                   }
    }

    
}

//$objUsuario = new Usuario();
//$objUsuario->guardarUsuario("Luis Gutierrez", "09090909", "lgutierrez",  
//"lgutierrez@ecotec.edu.ec", "1234");
//$respuesta = $objUsuario->actualizarUsuario("8", "Pedro Gutierrez", "09090909", "lgutierrez",  
//"lgutierrez@ecotec.edu.ec", "1234");
//var_dump($respuesta);
//$objUsuario->eliminarUsuarioLogico("3");
//echo json_encode($objUsuario->obtenerRegistros());