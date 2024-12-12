$("#btn-regresar").click(function(){
    window.open("gestion_usuarios.html", "_self");
});

$("#frm-usuario").submit(function(e){
    e.preventDefault();
    if($("#clave").val() != $("#re-clave").val()){
        alert("Las contraseñas no coinciden");
    }else{
        if(idUsuario == null){        
            $.ajax("../../../controladores/usuarios.controller.php",{
                data:{
                    opcion: "guardar",
                    nombre: $("#nombre").val(),
                    identificacion: $("#identificacion").val(),
                    nombre_usuario: $("#nombre_usuario").val(),
                    correo: $("#correo").val(),
                    tipo: $("#tipo").val(),
                    clave: $("#clave").val()
                }, 
                method: 'POST',
                success: function(resultado){
                    if(resultado.estado === "exito"){
                        alert("Se ingresó el usuario con éxito");
                    }else{
                        alert("Error al ingresar el usuario");
                    }
                }
            });
        }else{
            $.ajax("../../../controladores/usuarios.controller.php",{
                data:{
                    opcion: "editar",
                    id: idUsuario,
                    nombre: $("#nombre").val(),
                    identificacion: $("#identificacion").val(),
                    nombre_usuario: $("#nombre_usuario").val(),
                    tipo: $("#tipo").val(),
                    correo: $("#correo").val(),
                    clave: $("#clave").val()
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
    }
});

var idUsuario =  sessionStorage.getItem("id_usuario");
if(idUsuario != null){
    $.ajax("../../../controladores/usuarios.controller.php",{
        data:{
            opcion: "obtener_registro",
            id: idUsuario
        }, 
        method: 'POST',
        success: function(resultado){
            $("#titulo").text("Editar Información del Usuario");
            $("#nombre").val(resultado.nombre);
            $("#identificacion").val(resultado.identificacion);
            $("#nombre_usuario").val(resultado.nombre_usuario);
            $("#correo").val(resultado.correo);                    
        }

    });
}
