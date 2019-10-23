<?php

     include_once 'funciones/sesiones.php';
     include_once 'funciones/funciones.php';
     include_once 'templates/header.php';
     include_once 'templates/barra.php';
     include_once 'templates/navegacion.php';

 ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Crear registro de usuario manualmente
        <small>Llena el formulario para crear un usuario registrado</small>
      </h1>
    </section>

    <div class="row">
         <div class="col-md-8">
              <!-- Main content -->
              <section class="content">

               <!-- Default box -->
               <div class="box">
                  <div class="box-header with-border">
                   <h3 class="box-title">Crear usuario</h3>
                  </div>

                  <div class="box-body">
                       <!-- form start -->
                       <form role="form" method="post" action="modelo-registrado.php" name="guardar-registro" id="guardar-registro">
                            <div class="box-body">
                                <div class="form-group">
                                      <label for="nombre_registrado">Nombre:</label>
                                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                      <label for="apellido">Apellido:</label>
                                      <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido">
                                </div>
                                <div class="form-group">
                                      <label for="email">Email:</label>
                                      <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                     <div id="paquetes" class="paquetes">
                                          <div class="box-header with-border">
                                              <h3 class="box-title">Elige el número de boletos</h3>
                                          </div>
                                          <ul class="lista-precios clearfix row">
                                            <li class="col-md-4">
                                             <div class="tabla-precio text-center">
                                                <h3>Pase por día (viernes)</h3>
                                                <p class="numero">$30</p>
                                                <ul>
                                                  <li>Bocadillos gratis</li>
                                                  <li>Todas las conferencias</li>
                                                  <li>Todos los talleres</li>
                                                </ul>
                                                <div class="orden">
                                                     <label for="pase_dia">Boletos deseados:</label>
                                                     <input type="number" class="form-control" id="pase_dia" min="0" size="3" name="boletos[un_dia][cantidad]" placeholder="0">
                                                     <input type="hidden" name="boletos[un_dia][precio]" value="30">
                                                </div><!--orden pase_dia-->
                                             </div><!--tabla-precio-->
                                            </li>

                                            <li class="col-md-4">
                                             <div class="tabla-precio text-center">
                                                <h3>Todos los días</h3>
                                                <p class="numero">$50</p>
                                                <ul>
                                                  <li>Bocadillos gratis</li>
                                                  <li>Todas las conferencias</li>
                                                  <li>Todos los talleres</li>
                                                </ul>
                                                <div class="orden">
                                                     <label for="pase_completo">Boletos deseados:</label>
                                                     <input type="number" class="form-control" id="pase_completo" min="0" size="3" name="boletos[completo][cantidad]" placeholder="0">
                                                     <input type="hidden" name="boletos[completo][precio]" value="50">
                                                </div><!--orden pase_completo-->
                                             </div>
                                             <!--tabla-precio-->
                                            </li>

                                            <li class="col-md-4">
                                             <div class="tabla-precio text-center">
                                                <h3>Pase por 2 día (viernes y sábado)</h3>
                                                <p class="numero">$45</p>
                                                <ul>
                                                  <li>Bocadillos gratis</li>
                                                  <li>Todas las conferencias</li>
                                                  <li>Todos los talleres</li>
                                                </ul>
                                                <div class="orden">
                                                     <label for="pase_dosdias">Boletos deseados:</label>
                                                     <input type="number" class="form-control" id="pase_dosdias" min="0" size="3" name="boletos[2dias][cantidad]" placeholder="0">
                                                     <input type="hidden" name="boletos[2dias][precio]" value="45">
                                                </div><!--orden pase_dosdias-->
                                             </div><!--tabla-precio-->
                                            </li>
                                          </ul>
                                     </div><!--#paquetes-->
                                </div><!--#form-group -->

                                <div class="form-group">
                                     <div class="box-header with-border">
                                         <h3 class="box-title">Elige los talleres</h3>
                                     </div>
                                     <div id="eventos" class="eventos clearfix">
                                        <div class="caja">
                                             <?php
                                                  try {
                                                       $sql = "SELECT eventos.*, categoria_evento.cat_evento, invitados.nombre_invitado, invitados.apellido_invitado ";
                                                       $sql .= " FROM eventos ";
                                                       $sql .= " JOIN categoria_evento";
                                                       $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                                                       $sql .= " JOIN invitados ";
                                                       $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                                                       $sql .= " ORDER BY eventos.fecha_evento, eventos.id_cat_evento, eventos.hora_evento ";
                                                       // echo $sql;
                                                       $resultado = $conn->query($sql);
                                                  } catch (\Exception $e) {
                                                       echo $e->getMessage();
                                                  }

                                                  $eventos_dias = array();

                                                  // crear matriz asociativa para manejar mejor los datos obtenidos de la consulta
                                                  while ($eventos = $resultado->fetch_assoc()) {
                                                       $fecha = $eventos['fecha_evento'];
                                                       setlocale(LC_TIME,'en_US');
                                                       $dia_sem = strftime('%A',strtotime($fecha));
                                                       $con_tildes = array ("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday", "Sunday");
                                                       $sin_tildes  = array ("lunes","martes","miércoles","jueves","viernes","sábado", "domingo");
                                                       $dia_semana = str_replace($con_tildes, $sin_tildes, $dia_sem);
                                                       //echo $dia_semana;

                                                       $categoria = $eventos['cat_evento'];
                                                       $hora = $eventos['hora_evento'];
                                                       $hora_frmt = explode(":", $hora);
                                                       $dia = array(
                                                            'nombre_evento' => $eventos['nombre_evento'],
                                                            'hora' => "$hora_frmt[0]:$hora_frmt[1]",
                                                            'id' => $eventos['evento_id'],
                                                            'nombre_invitado' => $eventos['nombre_invitado'],
                                                            'apellido_invitado' => $eventos['apellido_invitado']
                                                       );
                                                       $eventos_dias[$dia_semana]['eventos'][$categoria][] = $dia;
                                                  }

                                                  /*$eventos = $resultado->fetch_assoc();
                                                  //Pruebo diferentes sentencias con
                                                  echo "<pre>";
                                                  var_dump($eventos_dias);
                                                  echo "</pre>";*/

                                              ?>

                                              <?php foreach ($eventos_dias as $dia => $eventos) { ?>
                                                   <div id="<?php echo str_replace('á', 'a', $dia); ?>" class="contenido-dia clearfix row">
                                                       <h4 class="text-center nombre_dia"><?php echo $dia; ?></h4>

                                                       <?php foreach ($eventos['eventos'] as $tipo => $evento_dia): ?>
                                                                <div class="col-md-4">
                                                                    <p><?php echo $tipo; ?></p>

                                                                    <?php foreach ($evento_dia as $evento) { ?>
                                                                         <label>
                                                                                <input type="checkbox" class="minimal" name="registro_evento[]" id="<?php echo $evento['id']; ?>" value="<?php echo $evento['id']; ?>">
                                                                                <time><?php echo $evento['hora']; ?></time> <?php echo $evento['nombre_evento']; ?>
                                                                                <br>
                                                                                <span class="autor"><?php echo $evento['nombre_invitado'] . " "  . $evento['apellido_invitado']; ?></span>
                                                                           </label>
                                                                    <?php } ?>
                                                                </div>
                                                      <?php endforeach; ?>
                                                   </div> <!--.contenido-dia-->
                                             <?php } ?>
                                          </div><!--.caja-->
                                     </div> <!--#eventos-->

                                          <div id="resumen" class="resumen ">
                                              <div class="box-header with-border">
                                                  <h3 class="box-title">Pagos y extras</h3>
                                              </div>
                                              <br>
                                             <div class="caja clearfix row">
                                                   <div class="extras col-md-6">
                                                         <div class="orden">
                                                             <label for="camisa_evento">Camisa del evento $10 <small>(promocion 7% dto.)</small></label>
                                                             <input type="number" class="form-control" min="0" id="camisa_evento" name="pedido_extra[camisas][cantidad]" size="3" placeholder="0">
                                                             <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                                                         </div> <!--.orden-->
                                                         <div class="orden">
                                                             <label for="etiquetas">Paquete de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript, Chrome)</small></label>
                                                             <input type="number" class="form-control" min="0" id="etiquetas" name="pedido_extra[etiquetas][cantidad]" size="3" placeholder="0">
                                                             <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                                                         </div> <!--.orden-->
                                                         <div class="orden">
                                                             <label for="regalo">Seleccione un regalo</label> <br>
                                                             <select id="regalo" name="regalo" required class="form-control seleccionar">
                                                                 <option value="">- Seleccione un regalo --</option>
                                                                 <option value="2">Etiquetas</option>
                                                                 <option value="1">Pulsera</option>
                                                                 <option value="3">Plumas</option>
                                                             </select>
                                                         </div><!--.orden-->
                                                         <br>
                                                         <input type="button" id="calcular" class="btn btn-success" value="Calcular">
                                                   </div> <!--.extras-->

                                                   <div class="total col-md-6">
                                                       <p>Resumen:</p>
                                                       <div id="lista-productos">

                                                       </div>
                                                       <p>Total:</p>
                                                       <div id="suma-total">

                                                       </div>
                                                       <input type="hidden" name="total_pedido" id="total_pedido">
                                                       <input type="hidden" name="total_descuento" id="total_descuento" value="total_descuento">
                                                   </div> <!--.total-->
                                             </div><!--.caja-->
                                          </div> <!--#resumen-->
                                 </div>

                           </div><!-- /.box-body interno -->
                  </div><!-- /.box-body -->

                       <div class="box-footer">
                            <input type="hidden" name="registro" value="nuevo">
                            <button type="submit" class="btn btn-primary" id="btnRegistro">Añadir</button>
                       </div>
                       </form>
                  </div>
                  <!-- /.box-body -->
               </div>
               <!-- /.box -->

              </section>
              <!-- /.content -->
         </div>
    </div>

  </div>
  <!-- /.content-wrapper -->

  <?php
     include_once 'templates/footer.php';
  ?>
