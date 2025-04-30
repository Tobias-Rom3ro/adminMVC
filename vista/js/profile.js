$(document).ready(function() { 
    ajaxVerUsuario();
    
})

function ajaxVerUsuario(){
    $.ajax({
        url: "../controlador/action/ajax_profile.php",
        dataType: "json",
        success: function(response){ 
            $("#FirstName").val(response.nombre);
            $("#Email").val(response.username);
            $("#Password").val(response.password);
        },
        
    error: function(xhr){
        alert("Ocurrió un error: " + xhr.status + " " + xhr.statusText);
      }});
}

/*
function ajaxRegistrarUsuario(nombre, correo, password, telefono, fechanac, sexo, pesokg, administrador){
    $.ajax({
        data: { 
                   "nombre" : nombre,
                   "correo" : correo,
                   "password" : password,
                   "telefono" : telefono,
                   "fechanac" : fechanac,
                   "sexo" : sexo,
                   "pesokg" : pesokg,
                   "administrador" : administrador
            },
            type: "POST",
            dataType: "json",
            url: "../controlador/accion/ajax_registrarUsuario.php",
    success: function(result){
        $('#modalCrearUsuario').modal('hide');
        insertarUsuarioEnTabla(nombre, correo, password, telefono, fechanac, sexo, pesokg, administrador);
    }})
} */
