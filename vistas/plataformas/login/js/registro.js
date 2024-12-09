$("#frm-registro").submit(function (e) {
    e.preventDefault();
    if ($("#clave").val() != $("#re-clave").val()) {
        alert("Las contraseñas no coinciden");
    } else {
        $.ajax("../../../controladores/usuarios.controller.php", {
            data: {
                opcion: "guardar",
                nombre: $("#nombre").val(),
                identificacion: $("#identificacion").val(),
                nombre_usuario: $("#nombre_usuario").val(),
                correo: $("#correo").val(),
                tipo: "General",
                clave: $("#clave").val()
            },
            method: 'POST',
            success: function (resultado) {
                if (resultado.estado === "exito") {
                    alert("Se ingresó el usuario con éxito");
                    window.open("iniciar_sesion.html", "_self");
                } else {
                    alert("Error al crear el usuario");
                }
            }
        });
    }
});