(function() {
     "use strict";

     document.addEventListener('DOMContentLoaded', function(){

          var mapa = document.getElementById('mapa')
          if (mapa) {
               var map = L.map('mapa').setView([20.674781, -103.38749], 16);

               L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                   attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
               }).addTo(map);

               L.marker([20.674781, -103.38749]).addTo(map)
                   .bindPopup('GDLWebCamp <br> Boletos disponibles')
                   .openPopup(); // info fija siempre visible
                   /*.bindTooltip('Un tooltip')
                   .openTooltip() // info en 1 globo que desaparece*/
          }

          //Campos Datos usuarios
          var nombre = document.getElementById('nombre');
          var apellido = document.getElementById('apellido');
          var email = document.getElementById('email');

          // Campo pases
          var pase_dia = document.getElementById('pase_dia');
          var pase_dosdias = document.getElementById('pase_dosdias');
          var pase_completo = document.getElementById('pase_completo');

          // Botones y divs
          var calcular = document.getElementById('calcular');
          var errorDiv = document.getElementById('error');
          var botonRegistro = document.getElementById('btnRegistro');
          var lista_productos = document.getElementById('lista-productos');
          var suma = document.getElementById('suma-total')

          //Extras
          var camisas = document.getElementById('camisa_evento')
          var etiquetas = document.getElementById('etiquetas')
          var regalo = document.getElementById('regalo')

          botonRegistro.disabled = true;

          // If para prevenir errores en el DOM,
          if (document.getElementById('calcular')) {

               // Llamadas a funciones
               calcular.addEventListener('click', calcularMontos)

               pase_dia.addEventListener('blur', mostrarDias) // en lugar de blur se puede utilizar 'input' o 'change'
               pase_dosdias.addEventListener('blur', mostrarDias) // blur = al salir del elemento indicado (perder el focus), p.e. dando un click fuera del campo... se realiza algo
               pase_completo.addEventListener('blur', mostrarDias)

               nombre.addEventListener('blur', validarCampos)
               apellido.addEventListener('blur', validarCampos)
               email.addEventListener('blur', validarCampos)
               email.addEventListener('blur', validarMail)

               var formulario_editar = document.getElementsByClassName('editar-registrado')
               if (formulario_editar.length > 0) {
                    if (pase_dia.value || pase_dosdias.value || pase_completo.value) {
                         mostrarDias();
                    }
               }


     /*        // controlar: deshabilitar y habilitar los botones
               botonRegistro.disabled = true
               botonRegistro.disabled = false
     */
               // FUNCIONES
               function validarMail() {
                    if (this.value.indexOf("@") > -1) { // indexOf() si no encuentra retur> -1; si es > ergo, encontró lo que buscaba.
                         errorDiv.style.display = 'none' // indexOf() busca en un array o cadena el caracter que le pases.
                         this.style.border = '1px solid #cccccc'
                    }
                    else {
                         errorDiv.style.display = 'block'
                         errorDiv.innerHTML = '<span>*</span> ¡Este campo es obligatorio!'
                         this.style.border = '1px solid red'
                         errorDiv.style.border = '1px solid red' // contraparte en css #error {clear: both;}
                    }
               }

               function validarCampos() {
                    if (this.value == '') {
                         errorDiv.style.display = 'block'
                         errorDiv.innerHTML = '<span>*</span> ¡Este campo debe tener una "@"!'
                         this.style.border = '1px solid red'
                         errorDiv.style.border = '1px solid red' // contraparte en css #error {clear: both;}
                    }
                    else {
                         errorDiv.style.display = 'none'
                         this.style.border = '1px solid #cccccc'
                    }
               }

               function calcularMontos(event) {
                    event.preventDefault();
                    if (regalo.value === '') {
                         alert('¡Debes elegir un regalo!')
                         regalo.focus()
                    }
                    else {
                         var boletosDia = parseInt(pase_dia.value, 10) || 0,
                             boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                             boletosCompleto = parseInt(pase_completo.value, 10) || 0,
                             cantCamisas = parseInt(camisas.value, 10) || 0,
                             cantEtiquetas = parseInt(etiquetas.value, 10) || 0
                             // parseInt convierte el input del usuario 'string', aunque sean números '20' en Integer, 10 es la base10 del s. decimal, || 'OR' si hay otro valor dejar en 0. Es validar en js.

                         var totalPagar = (boletosDia * 30) + (boletos2Dias * 45) + (boletosCompleto * 50) + ((cantCamisas * 10) *.93) + (cantEtiquetas * 2)

                         var listadoProductos = []
                         if (boletosDia >= 1) {
                              listadoProductos.push(`${boletosDia} Pase(s) por 1 día`)
                         }
                         if (boletos2Dias >= 1) {
                              listadoProductos.push(`${boletos2Dias} Pase(s) por 2 días`)
                         }
                         if (boletosCompleto >= 1) {
                              listadoProductos.push(`${boletosCompleto} Pase(s) completo(s)`)
                         }
                         if (cantCamisas >= 1) {
                              listadoProductos.push(`${cantCamisas} Camisa(s)`)
                         }
                         if (cantEtiquetas >= 1) {
                              listadoProductos.push(`${cantEtiquetas} Etiqueta(s)`)
                         }
                         listadoProductos.push(`Regalo: ${regalo.value}`)

                         lista_productos.style.display = "block" // en js muestras en bloque el estilo, pero en css display=none. Así, el estilo solo aparece cuando se añaden productos al resumen
                         lista_productos.innerHTML = ''
                         for (var i = 0; i < listadoProductos.length; i++) {
                              lista_productos.innerHTML += listadoProductos[i] + '<br/>' // .innerHTML impre/pone lo que está en js en html
                         }
                         suma.innerHTML = `$ ${totalPagar.toFixed(2)}`

                         botonRegistro.disabled = false;
                         document.getElementById('total_pedido').value = totalPagar.toFixed(2)
                    }
               }

               function mostrarDias() {
                    var boletosDia = parseInt(pase_dia.value, 10) || 0,
                        boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                        boletosCompleto = parseInt(pase_completo.value, 10) || 0

                    //console.log(boletosDia);

                    var diasElegidos = []

                    if(boletosDia > 0) {
                         diasElegidos.push("viernes");
                    } else {
                         document.getElementById("viernes").style.display="none";
                    }
                    if(boletos2Dias > 0) {
                         diasElegidos.push("viernes", "sabado");
                    } else {
                         document.getElementById("sabado").style.display="none";
                    }
                    if(boletosCompleto > 0) {
                         diasElegidos.push("viernes", "sabado", "domingo");
                    } else {
                         document.getElementById("domingo").style.display="none";
                    }
                    for (var i = 0; i < diasElegidos.length; i++) {
                         document.getElementById(diasElegidos[i]).style.display="block";
                    }
               }

               // funcion de validación nombre con funciones anónima
               nombre.addEventListener('blur', function() {
                    if (this.value == '') {
                         errorDiv.style.display ='block'
                         errorDiv.innerHTML = '<span>*</span> ¡Este campo es obligatorio!'
                         this.style.border = '1px solid red'
                         errorDiv.style.border = '1px solid red' // contraparte en css #error {clear: both;}
                    }
               });

               // funcion de validación apellido
               apellido.addEventListener('blur', function() {
                    if (this.value == '') {
                         errorDiv.style.display ='block'
                         errorDiv.innerHTML = '<span>*</span> ¡Este campo es obligatorio!'
                         this.style.border = '1px solid red'
                         errorDiv.style.border = '1px solid red' // contraparte en css #error {clear: both;}
                    }
               });

               // funcion de validación email
               email.addEventListener('blur', function() {
                    if (this.value == '') {
                         errorDiv.style.display ='block'
                         errorDiv.innerHTML = '<span>*</span> ¡Este campo es obligatorio!'
                         this.style.border = '1px solid red'
                         errorDiv.style.border = '1px solid red' // contraparte en css #error {clear: both;}
                    }
               });

          }
     }); // DOM CONTENT LOADED
})();
