$("#btn-nuevo-usuario").click(function(){
    window.open("modificar_usuario.html", "_self");
});

function editarUsuario(id){
    sessionStorage.setItem("id_usuario", id);
    window.open("modificar_usuario.html", "_self");
}

function eliminarUsuario(id){
    $.ajax("../../../controladores/usuarios.controller.php",{
        data:{
            opcion: "eliminar",
            id: id
        }, 
        method: 'POST',
        success: function(resultado){
            if(resultado.estado === "exito"){
                obtenerRegistros();
            }else{
                alert("Error al eliminar el usuario");
            }
        }
    });
}

function obtenerRegistros(){
    $.ajax("../../../controladores/usuarios.controller.php",{
        data:{
            opcion: "listado"
        }, 
        method: 'POST',
        success: function(resultado){
            $("#contenido-tabla").html("");
            resultado.forEach(element => {
                $("#contenido-tabla").append(
                    `<tr>
                        <td>${element.id_usuario}</td>
                        <td>${element.nombre}</td>
                        <td>${element.identificacion}</td>
                        <td>${element.nombre_usuario}</td>
                        <td>${element.correo}</td>
                        <td>${element.tipo}</td>
                        <td><button class='btn btn-primary btn-sm' onclick="editarUsuario(${element.id_usuario})">Editar</button></td>
                        <td><button class='btn btn-primary btn-sm' onclick="eliminarUsuario(${element.id_usuario})">Eliminar</button></td>   
                    </tr>`
                );
            });

        }

    });
}

sessionStorage.clear();
obtenerRegistros();
