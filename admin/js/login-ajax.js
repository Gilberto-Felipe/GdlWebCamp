$(document).ready(function() {
     //login ajax
     $('#login-admin').on('submit', function(e) {
          e.preventDefault();
          //console.log("¡Diste click en submit!");

          // obtengo los datos del formulario
          var datos = $(this).serializeArray();
          //console.log(datos);

          // crear llamada a ajax en jquery
          $.ajax({
               type: $(this).attr('method'),
               data: datos,
               url: $(this).attr('action'),
               dataType: 'json',
               success: function(data) {
                    console.log(data);

                    var resultado = data;
                    if (resultado.respuesta == 'correcto') {
                         swal(
                           '¡Login correcto!',
                           '¡Bienvenid@ '+resultado.usuario+'!',
                           'success'
                         )
                         setTimeout(function() {
                              window.location.href = 'admin-area.php';
                         }, 2000);
                    } else {
                         swal(
                           '¡Error!',
                           '¡Usuario o password incorrectos!',
                           'error'
                         )
                    }
               }
          })
     });
});
