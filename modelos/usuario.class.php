<?php
require_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;
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

    public function guardarUsuario($nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo = 'GENERAL')
    {
        $sql = "INSERT INTO usuarios (identificacion, nombre, nombre_usuario, clave, correo, tipo) 
        VALUES ('$identificacion','$nombre','$nombre_usuario', MD5('$clave'),'$correo', '$tipo')";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
    }

    public function actualizarUsuario($id, $nombre, $identificacion, $nombre_usuario, $correo, $clave, $tipo = 'GENERAL')
    {
        $sql = "UPDATE usuarios SET  nombre = '$nombre', identificacion = '$identificacion',
        nombre_usuario = '$nombre_usuario', correo = '$correo', clave=MD5('$clave'), tipo = '$tipo'
        WHERE id_usuario = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
        
    }

    public function eliminarUsuario($id) //Eliminado físico
    {
        $sql = "DELETE FROM usuarios WHERE id_usuario = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
            return false;
        }
        
    }

    public function eliminarUsuarioLogico($id)
    {
        $sql = "UPDATE usuarios SET estado = '0' WHERE id_usuario = '$id'";
        try{
            $this->conexion->query($sql);
            return true;
        }catch(Exception $e){
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
            guardarLog("usuario.log", $e->getMessage());
            return $arreglo;
        }
    }

    function obtenerRegistroPorId($id){
        $arreglo = [];
        $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id'";
        try{
            $resultados = $this->conexion->query($sql);
            while($fila = $resultados->fetch_assoc()){
                $arreglo = $fila; //Nuevo elemento
            }
            return $arreglo;
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
            return $arreglo;
        }
    }
    
    function validarAccesos($nombre_usuario, $clave){
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND clave = MD5('$clave')";
        try{
            $resultados = $this->conexion->query($sql);
            if($resultados->num_rows>0){
                return true;
            }else{
                return false;
            }  
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
        }
    }

    function validarLink($nombre_usuario, $clave){
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' AND clave = MD5('$clave')";
        try{
            $resultados = $this->conexion->query($sql);
            if ($resultados->num_rows > 0) {
                $usuario = $resultados->fetch_assoc();
                if ($usuario['tipo'] === "General") {
                    return true; 
                } else {
                    return false; 
                }
            }
        }catch(Exception $e){
            guardarLog("usuario.log", $e->getMessage());
        }
    }

    private function generarJWT($id_usuario, $nombre_usuario) {
        $clave_secreta = "mi_clave_secreta"; 
        
 
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  
        $payload = array(
            "iat" => $issuedAt,    
            "exp" => $expirationTime, 
            "data" => array(
                "id" => $id_usuario,
                "nombre_usuario" => $nombre_usuario
            )
        );
        // Codificar el JWT y retornarlo
       return JWT::encode($payload, $clave_secreta, 'HS256');
    }


    
}
