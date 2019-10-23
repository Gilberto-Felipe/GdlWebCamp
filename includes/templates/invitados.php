<?php
     try { // try/catch +- if/else
          require_once('includes/funciones/bd_conexion.php'); // es un include_once, mas exigente.
          $sql = " SELECT * FROM invitados "; // todo el código sql puede ir dentro de php; guardo la sentencia sql en 1 var. Luego compruebo imprimiendo
          $resultado = $conn->query($sql); // guardo el resultado de $conn (conexión) y de la consulta (query()) a bd. Traigo los datos de la bd.
     } catch (\Exception $e) {
          echo $e->getMessage();
     }
?>

<section class="invitados contenedor seccion">
     <h2>Invitados</h2>
          <ul class="lista-invitados clearfix">
               <?php while ($invitados = $resultado->fetch_assoc()) { ?>
                    <li>
                         <div class="invitado">
                              <a class="invitado-info" href="#invitado<?php echo $invitados['invitado_id']; ?>">
                                   <img src="img/invitados/<?php echo $invitados['url_imagen'] ?>" alt="imagen invitado">
                                   <p><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></p>
                              </a>
                         </div>
                    </li>
                    <div style="display:none;">
                         <div class="invitado-info" id="invitado<?php echo $invitados['invitado_id']; ?>">
                              <h2><?php echo $invitados['nombre_invitado'] . " " . $invitados['apellido_invitado']; ?></h2>
                              <img src="img/invitados/<?php echo $invitados['url_imagen']; ?>" alt="imagen invitado">
                              <p><?php echo $invitados['descripcion']; ?></p>
                         </div>
                    </div>
               <?php } // end del while del fetch_assoc() ?>
          </ul>
</section>

<?php $conn->close(); // cerrar la conexión ?>
