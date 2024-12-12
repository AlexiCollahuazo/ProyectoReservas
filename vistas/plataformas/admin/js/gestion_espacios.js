$("#btn-nueva-habitacion").click(function(){
    window.open("modificar_espacios.html", "_self");
});

function editarEspacio(id){
    sessionStorage.setItem("id_espacio", id);
    window.open("modificar_espacios.html", "_self");
}

function eliminarEspacio(id){
    $.ajax("../../../controladores/alojamiento.controller.php",{
        data:{
            opcion: "eliminar",
            id: id
        }, 
        method: 'POST',
        success: function(resultado){
            if(resultado.estado === "exito"){
                obtenerRegistros();
            }else{
                alert("Error al eliminar la habitación");
            }
        }
    });
}

function obtenerRegistros(){
    $.ajax("../../../controladores/alojamiento.controller.php",{
        data:{
            opcion: "listado"
        }, 
        method: 'POST',
        success: function(resultado){
            $("#contenido-tabla").html("");
            resultado.forEach(element => {
                
                $("#contenido-tabla").append(
                    `<tr>
                        <td>${element.id_espacio}</td>
                        <td>${element.nombre}</td>
                        <td>${element.descripcion}</td>
                        <td>${element.capacidad}</td>
                        <td>${element.precio_noche}</td>
                        <td>${element.imagen_url}</td>
                        <td>
                        <button class='btn btn-primary btn-sm' onclick="editarEspacio(${element.id_espacio})">Editar</button>
                        <button class='btn btn-primary btn-sm' onclick="eliminarEspacio(${element.id_espacio})">Eliminar</button>  
                        </td>
                        <td>
                        <button class='btn btn-primary btn-sm' onclick="reservarEspacio(${element.id_espacio})">Reservar</button>   
                        <button class='btn btn-primary btn-sm' onclick="cancelarEspacio(${element.id_espacio})">Cancelar</button></td>   
                    </tr>`
                );
            });

        }

    });
}

sessionStorage.clear();
obtenerRegistros();
