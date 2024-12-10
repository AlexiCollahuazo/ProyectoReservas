$("#frm-login").submit(function (e) {
    e.preventDefault();
    
      $.ajax("../../../controladores/usuarios.controller.php", {
        data: {
          opcion: "validar_accesos",           
          nombre_usuario: $("#nombre_usuario").val(),      
          clave: $("#clave").val()
        },
        method: 'POST',
        success: function (resultado) {
          if (resultado.estado === "exito") {
            alert("Usuario verificado");
                $.ajax("../../../controladores/usuarios.controller.php", {
                    data: {
                    opcion: "validar_link",           
                    nombre_usuario: $("#nombre_usuario").val(),
                    clave: $("#clave").val()
                    },
                    method: 'POST',
                    success: function (resultado) {
                        if(resultado.tipo=="General"){
                            window.open("../usuarios/index.html", "_self");
                        }else if(resultado.tipo=="Administrador"){
                            window.open("../admin/index.html", "_self");
                        }
                    }
                });
            //localStorage.setItem("jwt", resultado.jwt); // Nuevo
          } else {
            alert("Usuario y/o contraseña inválidos");
          }
        }
      });
  });

