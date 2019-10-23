

// creo función donde debe ir todo el código jquery
// el código debe ser en el orden en el que aparece en el Dom
$(function() { // es el DOMContentLoaded de jquery
     // alert('funciona') // compruebo que la función de jquery esté funcionando

     // Lettering método plugin
     $('.nombre-sitio').lettering() // selecciona las cada letra y la coloca en <span> para darles estilo css

     // Agregar clase a menú
     $('body.conferencia .navegacion-principal a:contains("Conferencia")').addClass('activo');
     $('body.calendario .navegacion-principal a:contains("Calendario")').addClass('activo');
     $('body.invitados .navegacion-principal a:contains("Invitados")').addClass('activo');


     // MENÚ BARRA NAVEGACIÓN FIJA
     var windowHeight = $(window).height() // método para saber el tamaño en píxeles de la ventana (el contendio que cabe en pantalla)
     //console.log(windowHeight);
     var barraAltura = $('.barra').innerHeight() // método que da la altura | .innerHeight(true) da más info
     //console.log(barraAltura); // para saber cuánto mide la barra

     // va a escuchar por los scroll
     $(window).scroll(function() {
          var scroll = $(window).scrollTop() // esta línea es la más importante, scrollTop() es la que hace el trabajo.
          //console.log(scroll); // muestra la cantidad de pixeles que recorres, puedes saber cuántos píxeles hay en tu página web.
          if (scroll > windowHeight) {
               //console.log('Ya rebasaste la altura de la ventana'); // compruebo
               $('.barra').addClass('fixed') // añado clase fixed para formatear en css; controlo en el Dom que se añada la clase
               $('body').css({'margin-top': barraAltura+'px'}) // quito el salto que da la barra cuando rebasa windowHeight
          }
          else {
               $('.barra').removeClass('fixed') // añado clase fixed para formatear en css; controlo en el Dom que se añada la clase
               //console.log('aún no'); // compruebo
               $('body').css({'margin-top': '0px'}) // quito el salto de la barra cuando regreso a la 1a vista de la ventana.
          }
     })

     // MENÚ RESPONSIVE HAMBURGUESA
     $('.menu-movil').on('click', function() {
          $('.navegacion-principal').slideToggle() // Toggle(altenar, pe. encender/apagar, quitar poner) .slideToggle mezcla de slideUp y slideDown
     })

     // PROGRMA DE CONFERENCIAS
     $('div.ocultar').hide() // ocultO las conferencias, talleres y seminarios || otra forma - css: div.ocultar {display: none;}

     $('.programa-evento .info-curso:first').show() // muestro el 1er elemento de .info-curso (talleres); el padre es .programa evento

     $('.menu-programa a:first').addClass('activo') // Tabs: (3) selecciono el 1er tab como activo x defecto. Compruebo en el Dom

     // funcion crear TABS
     $('.menu-programa a').on('click', function() {
          $('.menu-programa a').removeClass('activo') // (2) quito .clase a todos los 'a' de los tabs, pq sino, con addClass('activo'), todos van a estar seleccionados. Compurebo en el Dom
          $(this).addClass('activo') // Dar activo a los tabs: (1) añado clase activo (ya que se removió) sólo al tab clickeado. Compruebo en el Dom
          $('.ocultar').hide() // oculto la clase ocultar que contienen la info de talles, conferencias, seminarios.
          var enlace = $(this).attr('href') // selecciono/guardo los enlaces de los tabs
          //console.log(enlace); compruebo
          $(enlace).fadeIn(1000) // desvanecido; 1000 = 1 seg.
          return false // quito el brinco que hace el enlace tab al contenido
     })

     // Método Animaciones números con plugin animateNumber de jquery -  siempre revisar la doc del plugin.
     $('.resumen-evento li p').append('0');
     $('.resumen-evento').mouseenter(function() {
     $('.resumen-evento li:nth-child(1) p').animateNumber({number: 6}, 1200);
     $('.resumen-evento li:nth-child(2) p').animateNumber({number: 15}, 1200);
     $('.resumen-evento li:nth-child(3) p').animateNumber({number: 3}, 1500);
     $('.resumen-evento li:nth-child(4) p').animateNumber({number: 9}, 1500);
     });

     /*
     $('.resumen-evento li:nth-child(1) p').animateNumber({ number: 6}, 1200) // recibe ({ number: número}, duracion) 1000 = 1seg.
     $('.resumen-evento li:nth-child(2) p').animateNumber({ number: 15}, 1200) // nth-child elegir los elementos x posición. Super útil.
     $('.resumen-evento li:nth-child(3) p').animateNumber({ number: 3}, 1200)
     $('.resumen-evento li:nth-child(4) p').animateNumber({ number: 9}, 1200)*/

     // Método countdown de pluglin
     $('.cuenta-regresiva').countdown('2018/09/26 8:00:00', function(event) {
          $('#dias').html(event.strftime('%D'))
          $('#horas').html(event.strftime('%H'))
          $('#minutos').html(event.strftime('%M'))
          $('#segundos').html(event.strftime('%S'))
     })

     // Colorbox
     $('.invitado-info').colorbox({inline:true, width:"50%"})
     $('.boton_newsletter').colorbox({inline:true, width:"50%"})

})

// CÓDIOG PARA OCULTAR CONFERENCIAS Y TALLERES CUANDO SE VUELVE A 0 funcionó
/*
Hola se que es viejo, pero yo lo solucione de otra manera y tal vez te sirve, todo lo siguiente va luego de la funcion mostrar dias y luego de las variables claro.

if(boletosDia > 0) {
     diasElegidos.push("viernes");
     } else {
          document.getElementById("viernes").style.display="none";
     }
     if(boletos2dias > 0) {
          diasElegidos.push("viernes", "sabado");
     } else {
          document.getElementById("sabado").style.display="none";
     }
     if(boletoCompleto > 0) {
          diasElegidos.push("viernes", "sabado", "domingo");
     } else {
          document.getElementById("domingo").style.display="none";
     }
     for (var i = 0; i < diasElegidos.length; i++) {
          document.getElementById(diasElegidos[i]).style.display="block";
     }
*/
