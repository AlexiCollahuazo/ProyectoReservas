
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
