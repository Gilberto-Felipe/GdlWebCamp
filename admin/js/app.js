// interfaz del admin
$(document).ready(function () {
     $('.sidebar-menu').tree()

     $('#registros').DataTable({
          'paging'      : true,
          'pageLength'  : 10,
          'lengthChange': false,
          'searching'   : true,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false,
          'language'    : {
               paginate: {
                    next: 'Siguiente',
                    previous: 'Anterior',
                    last: 'Último',
                    first: 'Primero'
               },
               info: 'Mostrando _START_ a _END_ de _TOTAL_ resultados',
               emptyTable: 'No hay registros',
               infoEmpty: '0 registros',
               search: 'Buscar: '
          }
     });

     // deshabilito el botón para habilitarlo sólo cuando hayan confirmado el password
     $('#crear-registro-admin').attr('disabled', true);

     // evento para validar confirmar password
     $('#repetir_password').on('input', function() {
          let password_nuevo = $('#password').val();

          if ($(this).val() == password_nuevo) {
               $('#resultado_password').text('Correcto');
               $('#resultado_password').parents('.form-group').addClass('has-success').removeClass('has-error');
               $('input#password').parents('.form-group').addClass('has-success').removeClass('has-error');
               $('#crear-registro-admin').attr('disabled', false); // habilito el botón agregar
          } else {
               $('#resultado_password').text('¡No son iguales!');
               $('#resultado_password').parents('.form-group').addClass('has-error').removeClass('has-success');
               $('input#password').parents('.form-group').addClass('has-error').removeClass('has-success');
          }
     });

     //Date picker
     $('#fecha').datepicker({
       autoclose: true
     });

     //Initialize Select2 Elements
     $('.seleccionar').select2();

     //Timepicker
     $('.timepicker').timepicker({
       showInputs: false
     });

     //Font awesome icon picker
     $('#icono').iconpicker();

     //Flat red color scheme for iCheck
     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
       checkboxClass: 'icheckbox_flat-blue',
       radioClass   : 'iradio_flat-blue'
     });

     $.getJSON('servicio-registrados.php', function(data) {
          // LINE CHART Morris.js para gráficas
          var line = new Morris.Line({
               element: 'grafica-registros',
               resize: true,
               data: data,
               xkey: 'fecha',
               ykeys: ['cantidad'],
               labels: ['Item 1'],
               lineColors: ['#3c8dbc'],
               hideHover: 'auto'
          });
     });
});


/* Documentación
*.on('input'): escucha el input, mientras escribes.
*.on('blur'): escucha cuando te sales de ese elemento de html, es decir, cuando te desenfocas.
*/





















//
