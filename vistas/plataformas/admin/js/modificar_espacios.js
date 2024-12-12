$("#btn-regresar").click(function(){
    window.open("gestion_espacios.html", "_self");
});

$("#frm-espacio").submit(function(e){
    e.preventDefault();
        if(idEspacio== null){       
            $.ajax("../../../controladores/alojamiento.controller.php",{
                data:{
                    opcion: "guardar",
                    nombre: $("#nombre").val(),
                    descripcion: $("#descripcion").val(),
                    capacidad: $("#capacidad").val(),
                    precio_noche: $("#precio_noche").val(),
                    imagen_url: $("#imagen_url").val()

                }, 
                method: 'POST',
                success: function(resultado){
                    if(resultado.estado === "exito"){
                        alert("Se ingresó la habitación con éxito");
                    }else{
                        alert("Error al ingresar la habitación");
                    }
                }
            });
        }else{
            $.ajax("../../../controladores/alojamiento.controller.php",{
                data:{
                    opcion: "editar",
                    id_espacio: idEspacio,
                    nombre: $("#nombre").val(),
                    descripcion: $("#descripcion").val(),
                    capacidad: $("#capacidad").val(),
                    precio_noche: $("#precio_noche").val()
                }, 
                method: 'POST',
                success: function(resultado){
                    if(resultado.estado === "exito"){
                        alert("Se actualizo la habitación con éxito");
                    }else{
                        alert("Error al actualizar la habitación");
                    }
                },error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log("Error en la solicitud AJAX:", status, error);  // Capturar errores de AJAX
                }
            });

        }
});

var idEspacio =  sessionStorage.getItem("id_espacio");
if(idEspacio != null){
    $.ajax("../../../controladores/alojamiento.controller.php",{
        data:{
            opcion: "obtener_registro",
            id: idEspacio
        }, 
        method: 'POST',
        success: function(resultado){
            $("#titulo").text("Editar Información de la Habitación");
            $("#nombre").val(resultado.nombre);
            $("#descripcion").val(resultado.descripcion);
            $("#capacidad").val(resultado.capacidad);
            $("#precio_noche").val(resultado.precio_noche);
            $("#imagen_url").hide();
            $("#enunciado").hide();
            $("#imagen_url").removeAttr("required");
        }

    });
}
