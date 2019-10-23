<?php
     include_once 'funciones/sesiones.php';
     if($_SESSION['nivel'] == 0) {
          die('No permitido');
     }
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
             Lista de personas registradas
             <small></small>
           </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Maneja las personas registradas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Fecha registro</th>
                  <th>Artículos</th>
                  <th>Talleres</th>
                  <th>Regalo</th>
                  <th>Compra</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                     <?php
                         try {
                              $sql = "SELECT registrados.*, regalos.nombre_regalo FROM registrados ";
                              $sql .= "JOIN regalos ";
                              $sql .= "ON registrados.regalo = regalos.id_regalo ";
                              // echo $sql; // para ver la sentencia sql
                              $resultado = $conn->query($sql);
                         } catch (\Exception $e) {
                              $error = $e->getMessage();
                              echo $error;
                         }
                         // pruebo con echo "<pre>"; var_dump($registrados); echo "</pre>";

                         while ( $registrado = $resultado->fetch_assoc() ) { ?>
                              <tr>
                                   <td>
                                        <?php echo $registrado['nombre_registrado'] . " " . $registrado['apellido_registrado'];
                                        echo "<br>";
                                             $pagado = $registrado['pagado'];
                                             if ($pagado) {
                                                  echo '<span class="badge bg-green">Pagado</span>';
                                             }else {
                                                  echo '<span class="badge bg-red">No ha pagado</span>';
                                             }
                                         ?>
                                   </td>
                                   <td><?php echo $registrado['email_registrado']; ?></td>
                                   <td><?php echo $registrado['fecha_registro']; ?></td>
                                   <td>
                                        <?php
                                            $articulos = json_decode($registrado['pases_articulos'], true);
                                            $arreglo_articulos = array(
                                                'un_dia' => 'Pase un día',
                                                'pase_completo' => 'Pase Completo',
                                                'pase_2días' => 'Pase 2 días',
                                                'camisas' => 'Camisas',
                                                'etiquetas' => 'Etiquetas'
                                            );

                                            foreach ($articulos as $llave => $articulo){
                                                 if(isset($articulo["cantidad"])){
                                                     if($articulo["cantidad"] != ""){
                                                         echo $articulo["cantidad"]  . " " . $arreglo_articulos[$llave]."<br>";
                                                     }
                                                 } else{
                                                     echo $articulo . " " . $arreglo_articulos[$llave]."<br>";
                                                 }
                                             }
                                        ?>
                                    </td>
                                   <td>
                                        <?php
                                             $eventos_resultado =  $registrado['talleres_registrados'];
                                             $talleres = json_decode($eventos_resultado, true);
                                             $talleres = implode("', '", $talleres['eventos']);

                                             $sql_talleres = "SELECT nombre_evento, fecha_evento, hora_evento FROM eventos WHERE clave IN ('$talleres') OR evento_id IN ('$talleres') ";
                                             //echo $sql_talleres;

                                             $resultado_talleres = $conn->query($sql_talleres);

                                             while ($eventos = $resultado_talleres->fetch_assoc()) {
                                                  echo $eventos['nombre_evento'] . " " . $eventos['fecha_evento'] . " " . $eventos['hora_evento'] . "<br>";
                                             }

                                        ?>
                                   </td>
                                   <td><?php echo $registrado['nombre_regalo']; ?></td>
                                   <td>$ <?php echo $registrado['total_pagado']; ?></td>
                                   <td>
                                        <a href="editar-registro.php?id=<?php echo $registrado['id_registrado']; ?>" class="btn bg-orange btn-flat margin">
                                             <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="#" data-id="<?php echo $registrado['id_registrado']; ?>" data-tipo="registrado" class="btn bg-maroon btn-flat margin borrar-registro">
                                             <i class="fa fa-trash"></i>
                                        </a>
                                   </td>
                              </tr>

                         <?php } ?>

                </tbody>
                <tfoot>
                <tr>
                     <th>Nombre</th>
                     <th>Icono</th>
                     <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
     include_once 'templates/footer.php';
  ?>
