function cancelarEspacio(id){
    $.ajax("../../../controladores/reserva.controller.php",{
        data:{
            opcion: "cancelar",
            id_reserva: id
        }, 
        method: 'POST',
        success: function(resultado){
            alert("La reserva fue cancelada");
            actualizar();
        }
    });
}

var idEspacio =  sessionStorage.getItem("id_espacio");
if(idEspacio != null){
    actualizar();
}

function actualizar(){
    $.ajax("../../../controladores/reserva.controller.php",{
        data:{
            opcion: "listado_habitacion",
            id_espacio: idEspacio
        }, 
        method: 'POST',
        success: function(resultado){
            $("#contenido-tabla").html("");
            if (!resultado || resultado.length === 0) {
                $("#contenido-tabla").append(
                    "<tr><td colspan='7'>No hay reservas disponibles</td></tr>"
                );
            } else{
            resultado.forEach(element => { 
                $("#contenido-tabla").append(
                    `<tr>
                        <td>${element.id_reserva}</td>
                        <td>${element.id_espacio}</td>
                        <td>${element.id_usuario}</td>
                        <td>${element.fecha_inicio}</td>
                        <td>${element.fecha_fin}</td>
                        <td>${element.observaciones == null ? 'Sin comentarios' : element.observaciones}</td>
                        <td>  
                        <button class='btn btn-primary btn-sm' onclick="cancelarEspacio(${element.id_reserva})">Cancelar</button></td> 
                    </tr>`
                );
            });
        }
    }
    });
}