<?php include_once 'includes/templates/header.php'; ?>


     <section class="seccion contenedor">
          <h2>Calendario de eventos</h2>
     <?php // query en php
          try { // try/catch +- if/else
               require_once('includes/funciones/bd_conexion.php'); // es un include_once, mas exigente.
               $sql = " SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado "; // todo el código sql puede ir dentro de php; guardo la sentencia sql en 1 var. Después puedo utilizar la variable para comprobar o revisar errores.
               $sql .= " FROM eventos ";
               $sql .= " INNER JOIN categoria_evento ";
               $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
               $sql .= " INNER JOIN invitados ";
               $sql .= " ON eventos.id_inv = invitados.invitado_id ";
               $sql .= " ORDER BY evento_id ";
               $resultado = $conn->query($sql); // guardo el resultado de $conn (conexión) y de la consulta (query()) a bd. Traigo los datos de la bd.
          } catch (\Exception $e) {
               echo $e->getMessage();
          }
     ?>

          <div class="calendario">
          <?php
               // echo $sql; // para comprobar si escribí bien el código sql. Puedo verificar en la bd, y hacer la consulta usando IGráfica.
               //$eventos = $resultado->fetch_assoc(); // creo variable para guardar el resultado de consulta, y lo guardo en un array asociativo (fetch_assoc()).
               // fetch_assoc solo imprime un registro, con while los vamos a imprimir todos.

               $calendario = array(); // creo var para formatear el array de salida
               while ($eventos = $resultado->fetch_assoc()) { ?>

                    <?php
                    // Obtengo fecha del evento o el criterio para ordenar el array, debe ser un array hijo
                    $fecha = $eventos['fecha_evento'];
                    $categoria = $eventos['cat_evento'];

                    $evento = array( // formateas array como asociado con sus keys que son los campos de la base datos
                         'titulo' => $eventos['nombre_evento'],
                         'fecha' => $eventos['fecha_evento'],
                         'hora' =>$eventos['hora_evento'],
                         'categoria' =>$eventos['cat_evento'],
                         'icono' => $eventos['icono'],
                         'invitado' =>$eventos['nombre_invitado'] . " " . $eventos['apellido_invitado']
                    );

                    $calendario[$fecha][] = $evento; // Creo arreglo tridimensional puedo cambiar [$var] el criterio de ordenación.
                    // arrya Padre calendario, tiene hijos(arrayfechas), cada fecha tiene hijos(arrayevento), cada evento tiene 5 datos
                    // super para ordenar y tener control sobre la info que viene de la bd.
                    // lleno el arreglo. En cada iteración, va a colocar info del evento (asociado)
                    ?>
               <?php } // end del while del fetch_assoc() ?>

               <?php // Imprimo todos los eventos con 1 foreach
                    foreach ($calendario as $dia => $lista_eventos) { ?>
                         <h3>
                              <i class="fas fa-calendar-alt"></i>
                              <?php
                                   // Unix formatear fecha a español, defecto está inglés.
                                   setlocale(LC_TIME, 'es_ES.UTF-8');
                                   // windows
                                   setlocale(LC_TIME, 'spanish');

                                   echo utf8_encode(strftime("%A, %d de %B del %Y", strtotime($dia))); // date($var) formatea fechas ?>
                         </h3>
                              <?php foreach ($lista_eventos as $evento) { ?>
                                   <div class="dia">
                                        <p class="titulo"> <?php echo $evento['titulo']; ?> </p>
                                        <p class="hora">
                                             <i class="far fa-clock" aria-hidden="true"></i>
                                             <?php echo $evento['hora']; ?>
                                        </p>
                                        <p>
                                             <i class="fa <?php echo $evento['icono']; ?>" aria-hidden="true"></i>
                                             <?php echo $evento['categoria']; ?>
                                        </p>
                                        <p>
                                             <i class="fa fa-user" aria-hidden="true"></i>
                                             <?php echo $evento['invitado']; ?>
                                        </p>

                                   </div>
                              <?php } // end foreach $eventos ?>
                    <?php } // end foreach $dias ?>

               <!--<pre>
                    <?php var_dump($calendario); // imprimo el array formateado.
                         // echo $evento['key']; //accedo a cada llave, imprimo su valor.
                    ?>
               </pre> -->
          </div><!--.calendario-->

     <?php $conn->close(); // cerrar la conexión ?>

  </section>

  <?php include_once 'includes/templates/footer.php'; ?>
