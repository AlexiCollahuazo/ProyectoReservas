<?php
class Reserva {
    private $id;
    private $id_usuario;
    private $id_alojamiento;
    private $fecha_reserva;
    private $fecha_ingreso;
    private $fecha_salida;
    private $estado;
    private $codigo_qr;
    private $conexion;

    // Constructor
    function __construct() {
        global $ip, $usuario, $clave, $nombre_bd;
        // Crear una conexión a la base de datos
        $this->conexion = new mysqli($ip, $usuario, $clave, $nombre_bd);
        if ($this->conexion->connect_errno) {
            echo "Error: " . $this->conexion->connect_errno;
        }
    }


    public function crearReserva($id_usuario, $id_alojamiento, $fecha_reserva, $fecha_ingreso, $fecha_salida) {
        $sql = "SELECT * FROM alojamientos WHERE id = '$id_alojamiento' AND disponibilidad = 1";
        $result = $this->conexion->query($sql);
        if ($result->num_rows > 0) {
            $sql_insert = "INSERT INTO reservas (id_usuario, id_alojamiento, fecha_reserva, fecha_ingreso, fecha_salida, estado)
                           VALUES ('$id_usuario', '$id_alojamiento', '$fecha_reserva', '$fecha_ingreso', '$fecha_salida', 1)";
            if ($this->conexion->query($sql_insert)) {
               
                $this->id = $this->conexion->insert_id;
                // Generar código QR
                $this->codigo_qr = $this->generarCodigoQR();
                // EL metodo de correo 
                $this->enviarCorreoConfirmacionReserva();
                return true;
            }
        }
        return false;
    }

       public function modificarReserva($id_reserva, $fecha_ingreso, $fecha_salida) {
        $sql = "UPDATE reservas SET fecha_ingreso = '$fecha_ingreso', fecha_salida = '$fecha_salida' WHERE id = '$id_reserva'";
        try {
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
            // Guardar el log de error (opcional)
            guardarLog("reserva.log", $e->getMessage());
            return false;
        }
    }
    function obtenerRegistros(){//ORDER BY fecha_reserva 
        $arreglo = [];
        $sql = "SELECT * FROM reservas ORDER BY fecha_inicio ASC";
        try{
            $resultados = $this->conexion->query($sql);
            while($fila = $resultados->fetch_assoc()){
                $arreglo[] = $fila; //Nuevo elemento
            }
            return $arreglo;
        }catch(Exception $e){
            guardarLog("reserva.log", $e->getMessage());
            return $arreglo;
        }
    }
    
    //Buscar reserva activas por habitacion
    public function consultarReservaHabitacion($id_espacio) {
        $arreglo = [];
        $sql = "SELECT * FROM reservas WHERE id_espacio = '$id_espacio' AND estado='ACTIVA' ORDER BY fecha_inicio ASC";
        try{
            $resultados = $this->conexion->query($sql);
            while($fila = $resultados->fetch_assoc()){
                $arreglo[] = $fila; //Nuevo elemento
            }
            return $arreglo;
        }catch(Exception $e){
            guardarLog("reserva.log", $e->getMessage());
            return $arreglo;
        }
    }

     public function cancelarReserva($id_reserva) {
        $sql = "UPDATE reservas SET estado = 'CANCELADA' WHERE id_reserva = '$id_reserva'";
        try {
            $this->conexion->query($sql);
            return true;
        } catch (Exception $e) {
            // Guardar el log de error (opcional)
            guardarLog("reserva.log", $e->getMessage());
            return false;
        }
    }

     public function verHistorialReservas($id_usuario) {
        $arreglo = [];
        $sql = "SELECT * FROM reservas WHERE id_usuario = '$id_usuario' ORDER BY fecha_reserva DESC";
        try {
            $resultados = $this->conexion->query($sql);
            while ($fila = $resultados->fetch_assoc()) {
                $arreglo[] = $fila;
            }
            return $arreglo;
        } catch (Exception $e) {
            guardarLog("reserva.log", $e->getMessage());
            return $arreglo;
        }
    }


     private function generarCodigoQR() {
       // $codigo_qr = "QR-" . $this->id . "-" . time();

       // return $codigo_qr;
    }

     private function enviarCorreoConfirmacionReserva() {
       // AQUI VA LA LOGICA PARA ENVIAR CORREOS :V, USAREMOS MAILTRAP
    }
/*
    public function obtenerDetallesReserva($id_reserva) {
        $sql = "SELECT * FROM reservas WHERE id = '$id_reserva'";
        try {
            $resultados = $this->conexion->query($sql);
            if ($resultados->num_rows > 0) {
                return $resultados->fetch_assoc();
            }
            return null;
        } catch (Exception $e) {
            guardarLog("reserva.log", $e->getMessage());
            return null;
        }
    }*/


}