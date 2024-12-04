<?php
class Administrador {
    // Atributos de la clase Administrador
    private $id;
    private $nombre;
    private $correo;
    private $tipo_usuario;  
    private $conexion;

    function __construct(){
        global $ip, $usuario, $clave, $nombre_bd;
        $this->conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);
        if($this->conexion->connect_errno){
            echo "Error: ".$this->conexion->connect_errno;
        }
    }


    public function verEstadisticas() {
        $estadisticas = [];

        $sql_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios WHERE estado = 1";
        $resultado_usuarios = $this->conexion->query($sql_usuarios);
        $estadisticas['total_usuarios'] = $resultado_usuarios->fetch_assoc()['total_usuarios'];

        $sql_alojamientos = "SELECT COUNT(*) AS total_alojamientos FROM alojamientos WHERE estado = 1";
        $resultado_alojamientos = $this->conexion->query($sql_alojamientos);
        $estadisticas['total_alojamientos'] = $resultado_alojamientos->fetch_assoc()['total_alojamientos'];

        $sql_reservas = "SELECT COUNT(*) AS total_reservas FROM reservas WHERE estado = 1";
        $resultado_reservas = $this->conexion->query($sql_reservas);
        $estadisticas['total_reservas'] = $resultado_reservas->fetch_assoc()['total_reservas'];

        return $estadisticas;
    }

    public function gestionarUsuarios() {
        $usuarios = [];

        // Obtener todos los usuarios
        $sql = "SELECT * FROM usuarios";
        $resultado = $this->conexion->query($sql);
        while($fila = $resultado->fetch_assoc()){
            $usuarios[] = $fila;
        }

        return $usuarios;
    }


    public function gestionarAlojamientos() {
        $alojamientos = [];

        // Obtener todos los alojamientos
        $sql = "SELECT * FROM alojamientos";
        $resultado = $this->conexion->query($sql);
        while($fila = $resultado->fetch_assoc()){
            $alojamientos[] = $fila;
        }

        return $alojamientos;
    }


    public function verHistorialReservas() {
        $historial = [];

        $sql = "SELECT * FROM reservas";
        $resultado = $this->conexion->query($sql);
        while($fila = $resultado->fetch_assoc()){
            $historial[] = $fila;
        }

        return $historial;
    }
}
?>