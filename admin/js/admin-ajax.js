$(document).ready(function() {
     // editar un registro
     $('#guardar-registro').on('submit', function(e) {
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
                    if (resultado.respuesta == 'exito') {
                         swal(
                           '¡Correcto!',
                           '¡El administrador se guradó correctamente!',
                           'success'
                         )
                    } else {
                         swal(
                           '¡Error!',
                           '¡Huno un error!',
                           'error'
                         )
                    }
               }
          })

     });

     // Se ejecuta cuando hay un archivo
     // editar un registro
     $('#guardar-registro-archivo').on('submit', function(e) {
          e.preventDefault();
          //console.log("¡Diste click en submit!");

          // obtengo los datos del formulario
          var datos = new FormData(this);
          //console.log(datos);

          // crear llamada a ajax en jquery
          $.ajax({
               type: $(this).attr('method'),
               data: datos,
               url: $(this).attr('action'),
               dataType: 'json',
               contentType: false,
               processData: false,
               async: true,
               cache: false,
               success: function(data) {
                    console.log(data);
                    var resultado = data;
                    if (resultado.respuesta == 'exito') {
                         swal(
                           '¡Correcto!',
                           '¡El administrador se guradó correctamente!',
                           'success'
                         )
                    } else {
                         swal(
                           '¡Error!',
                           '¡Huno un error!',
                           'error'
                         )
                    }
               }
          })

     });


     // eliminar un registro
     $('.borrar-registro').on('click', function(e) {
          e.preventDefault();

          var id = $(this).attr('data-id');
          var tipo = $(this).attr('data-tipo');
          //console.log(`ID: ${id}`);

          // mostar alertas sweetalert2
          swal({
               title: 'Estás Seguro?',
               text: "Esto no se puede deshacer!",
               type: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Si, borrar!!',
               cancelButtonText: 'No, Cancelar',
               confirmButtonClass: 'btn btn-success',
               cancelButtonClass: 'btn btn-danger',
               buttonsStyling: false,
               reverseButtons: false
          }).then((result) => {
               if (result.value) {
                    $.ajax({
                         type:'post',
                         data: {
                              'id': id,
                              'registro': 'eliminar'
                         },
                         url: 'modelo-'+tipo+'.php',
                         success: function(data){
                              console.log(data);
                              var resultado = JSON.parse(data);
                              if(resultado.respuesta == 'exito'){
                                   swal(
                                        'Eliminado!',
                                        'Registro eliminado',
                                        'success'
                                   )
                                   jQuery('[data-id="'+resultado.id_eliminado+'"]').parents('tr').remove();
                              }
                         }
                    })
               } else if (result.dismiss === 'cancel') {
                    swal(
                         '¡Error!',
                         'No se eliminó el registro',
                         'error'
                    )
               }
          })
     });
});

/* Documentación
*serializeArray(); f que itera sobre todos los campos para obtener información de un formulario. Crea un array de objetos {key. valor} por c/d campo.
*JSON.parse(): analiza/transforma un string formateado en json a un objeto json.
*.parents(): busca el elemento/nodo padre 'indicado' en el DOM.
*/
