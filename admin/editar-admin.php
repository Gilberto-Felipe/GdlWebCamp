<?php
     include_once 'funciones/sesiones.php';
     include_once 'funciones/funciones.php';
     $id = $_GET['id'];
     /*echo "<pre>";
          var_dump($_GET);
     echo "</pre>";*/
     if (!filter_var($id, FILTER_VALIDATE_INT)) {
          die("Error!!");
     }
     include_once 'templates/header.php';
     include_once 'templates/barra.php';
     include_once 'templates/navegacion.php';
 ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Editar administrador
        <small>Puedes editar los datos del administrador</small>
      </h1>
    </section>

    <div class="row">
         <div class="col-md-8">
              <!-- Main content -->
              <section class="content">

               <!-- Default box -->
               <div class="box">
                  <div class="box-header with-border">
                   <h3 class="box-title">Editar administrador</h3>
                  </div>

                  <div class="box-body">
                       <?php
                              $sql = "SELECT * FROM admins WHERE id_admin = $id ";
                              $resultado = $conn->query($sql);
                              $admin = $resultado->fetch_assoc();
                              /*// compruebo
                              echo "<pre>";
                                   var_dump($admin);
                              echo "</pre>";*/

                       ?>


                       <!-- form start -->
                       <form role="form" method="post" action="modelo-admin.php" name="guardar-registro" id="guardar-registro">
                       <div class="box-body">
                           <div class="form-group">
                                 <label for="usuario">Usuario:</label>
                                 <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" value="<?php echo $admin['usuario']; ?>">
                           </div>
                           <div class="form-group">
                                 <label for="nombre">Nombre:</label>
                                 <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre completo" value="<?php echo $admin['nombre']; ?>">
                           </div>
                           <div class="form-group">
                                 <label for="password">Password:</label>
                                 <input type="password" class="form-control" id="password" name="password" placeholder="Password para iniciar sesión">
                           </div>
                       </div>
                       <!-- /.box-body -->

                       <div class="box-footer">
                            <input type="hidden" name="registro" value="actualizar">
                            <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
