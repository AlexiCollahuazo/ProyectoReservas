<?php

function guardarLog($nombreArchivo, $mensaje){
    $archivo = fopen("../logs/".$nombreArchivo, "a+");
    fwrite($archivo, date("Y-m-d H:i:s"). ": ".$mensaje.PHP_EOL);
    fclose($archivo);
}