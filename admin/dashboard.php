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
        Dashboard
        <small>Información sobre el evento</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
         <h2 class="page-header">Resumen de registros</h2>
         <div class="row">
              <div class="box-body chart-responsive">
                <div class="chart" id="grafica-registros" style="height: 300px;"></div>
              </div>
         </div>


         <div class="row">
              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                         $sql = "SELECT count(id_registrado) as registros FROM registrados ";
                         $resultado = $conn->query($sql);
                         $registrados = $resultado->fetch_assoc();

                    ?>
                    <div class="small-box bg-aqua">
                       <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total registrados</p>
                       </div>
                       <div class="icon">
                           <i class="fas fa-user"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                    </div>
              </div>

              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                         $sql = "SELECT count(id_registrado) as registros FROM registrados where pagado = 1 ";
                         $resultado = $conn->query($sql);
                         $registrados = $resultado->fetch_assoc();

                    ?>
                    <div class="small-box bg-yellow">
                       <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total pagados</p>
                       </div>
                       <div class="icon">
                          <i class="fas fa-users"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                    </div>
              </div>

              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                         $sql = "SELECT count(id_registrado) as registros FROM registrados where pagado = 0 ";
                         $resultado = $conn->query($sql);
                         $registrados = $resultado->fetch_assoc();

                    ?>
                    <div class="small-box bg-red">
                       <div class="inner">
                        <h3><?php echo $registrados['registros']; ?></h3>

                        <p>Total sin pagar</p>
                       </div>
                       <div class="icon">
                          <i class="fas fa-user-times"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                    </div>
              </div>

              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                         $sql = "SELECT cast(sum(total_pagado) as decimal(11,2)) as recaudado FROM registrados where pagado = 1 ";
                         $resultado = $conn->query($sql);
                         $registrados = $resultado->fetch_assoc();

                    ?>
                    <div class="small-box bg-green">
                       <div class="inner">
                        <h3>$<?php echo $registrados['recaudado']; ?></h3>

                        <p>Total recaudado</p>
                       </div>
                       <div class="icon">
                          <i class="fas fa-dollar-sign"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                    </div>
              </div>
         </div>

         <h2 class="page-header">Regalos</h2>
         <div class="row">
              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                        $sql = "SELECT count(total_pagado) as pulseras FROM registrados where regalo = 1 and pagado = 1 ";
                        $resultado = $conn->query($sql);
                        $regalo = $resultado->fetch_assoc();

                   ?>
                   <div class="small-box bg-orange">
                       <div class="inner">
                        <h3><?php echo $regalo['pulseras']; ?></h3>

                        <p>Pulseras</p>
                       </div>
                       <div class="icon">
                         <i class="fas fa-circle-notch"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                   </div>
              </div>

              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                        $sql = "SELECT count(total_pagado) as etiquetas FROM registrados where regalo = 2 and pagado = 1 ";
                        $resultado = $conn->query($sql);
                        $regalo = $resultado->fetch_assoc();

                   ?>
                   <div class="small-box bg-teal">
                       <div class="inner">
                        <h3><?php echo $regalo['etiquetas']; ?></h3>

                        <p>Etiquetas</p>
                       </div>
                       <div class="icon">
                         <i class="fab fa-github-alt"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                   </div>
              </div>

              <div class="col-lg-3 col-xs-6"><!-- small box -->
                   <?php
                        $sql = "SELECT count(total_pagado) as plumas FROM registrados where regalo = 3 and pagado = 1 ";
                        $resultado = $conn->query($sql);
                        $regalo = $resultado->fetch_assoc();

                   ?>
                   <div class="small-box bg-lime">
                       <div class="inner">
                        <h3><?php echo $regalo['plumas']; ?></h3>

                        <p>Plumas</p>
                       </div>
                       <div class="icon">
                         <i class="fas fa-pen"></i>
                       </div>
                       <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fa fa-arrow-circle-right"></i>
                       </a>
                   </div>
              </div>

         </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php
     include_once 'templates/footer.php';
  ?>
