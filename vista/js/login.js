

//Aqui es donde usará jQuery ---> es para tener más claro, más corto código Javascript

$(document).ready(function(){  // es el main jQuery
    id=null;
    $(document).on('click', '#btnSubmit', function(){

        user= $("#exampleInputEmail").val();   //document.getElementById("exampleInputEmail")
        pass= $("#exampleInputPassword").val();  //document.getElementById("exampleInputPassword")

        //Incluir todas las validaciones..
        if(user!="" && pass!=""){

            ajaxLogin(user, pass);

        }
        else{
            Swal.fire({  // es para reemplazar el sweet alert
                text:"Digite los CAMPOS del correo y/o contraseña correctamente",
                icon: "warning",
                title: "Inicio de Sesión"

            })


        }
    });
  });



// Aqui viene el uso de AJAX con jQuery
function ajaxLogin(user, pass){
        $.ajax({ // sin utilizar XML,... usar json
            data: { //Datos a enviar
                   "user" : user,
                   "pass": pass
            },
            type: "POST",
            dataType: "json",
            url: "../controlador/action/ajax_login.php"
        })
         .done(function(response) {   // Cuando no hay problema OK http 200
            var mens=response.msg;

            if(mens!=""){
                Swal.fire({
                    text:mens,
                    icon: response.type,
                    title: "Inicio de Sesión"

                }).then((result) => {
                    if (result.isConfirmed) {
                    $(location).attr('href',response.ruta); //Redireccinar a una ruta
                    }
                  })


            }
            /* hacer append, modificar o eliminar de lo ingresau */
         })
         .fail(function(jqXHR, textStatus, errorThrown) {  // Si encuentra algun problema

            Swal.fire({
                title: "ALERTA",
                icon: "error",
                text: "La solicitud ha fallado: " +  errorThrown
            });
        });
}
