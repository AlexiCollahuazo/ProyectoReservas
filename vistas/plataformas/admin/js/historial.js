function obtenerRegistros(){
    $.ajax("../../../controladores/reserva.controller.php",{
        data:{
            opcion: "listado"
        }, 
        method: 'POST',
        success: function(resultado){
            $("#contenido-tabla").html("");
            resultado.forEach(element => {
                
                $("#contenido-tabla").append(
                    `<tr>
                        <td>${element.id_reserva}</td>
                        <td>${element.id_espacio}</td>
                        <td>${element.id_usuario}</td>
                        <td>${element.fecha_inicio}</td>
                        <td>${element.fecha_fin}</td>
                        <td>${element.estado}</td>
                        <td>${element.observaciones}</td>
                    </tr>`
                );
            });
        }

    });
}

sessionStorage.clear();
obtenerRegistros();
