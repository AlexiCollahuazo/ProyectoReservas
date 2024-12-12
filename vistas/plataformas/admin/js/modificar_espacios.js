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
                    id: idEspacio,
                    nombre: $("#nombre").val(),
                    descripcion: $("#descripcion").val(),
                    capacidad: $("#capacidad").val(),
                    precio_noche: $("#precio_noche").val(),
                    imagen_url: $("#imagen_url").val()
                }, 
                method: 'POST',
                success: function(resultado){
                    if(resultado.estado === "exito"){
                        alert("Se ingresó el usuario con éxito");
                    }else{
                        alert("Error al eliminar el usuario");
                    }
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
            $("#imagen_url").val(resultado.imagen_url); 
        }

    });
}
