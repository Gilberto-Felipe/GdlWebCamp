<?php if(isset($_POST['submit'])): // validación
     $nombre = $_POST['nombre'];
     $apellido = $_POST['apelido'];
     $email = $_POST['email'];
     $regalo = $_POST['regalo'];
     $total = $_POST['total_pedido'];
     $fecha = date('Y-m-d H:i:s');
     // pedidos
     $boletos = $_POST['boletos'];
     $camisas = $_POST['pedido_camisas'];
     $etiquetas = $_POST['pedido_etiquetas'];
     include_once 'includes/funciones/funciones.php';
     $pedido = productos_json($boletos, $camisas, $etiquetas); // siempre utilices 1 fun con return debes asignarla a una var.
     // eventos
     $eventos = $_POST['registro'];
     $registro = eventos_json($eventos);
     //Prepared statements
     try {
         require_once('includes/funciones/bd_conexion.php'); // es un include_once, mas exigente.
         $stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
         $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
         $stmt->execute();
         $stmt->close();
         $conn->close();
         header('Location: validar_registro.php?exitoso=1');
     } catch (\Exception $e) {
         echo $e->getMessage();
    }
endif; ?>

<?php include_once 'includes/templates/header.php'; ?>

<section class="seccion contenedor">
     <h2>Resumen registro</h2>
          <?php if (isset($_GET['exitoso'])): ?>
               <?php if ($_GET['exitoso'] == 1): ?>
                    <?php echo '¡Registro exitoso!' ?>
               <?php endif; ?>
          <?php endif; ?>
</section>


<?php include_once 'includes/templates/footer.php'; ?>

<?php
/*Prepared statements
Una función de MYSQL que permite ejecurtar repetidamente la misma (similar) declaraciones sql con una gran eficiencia.
1. Inserta datos sin especificar sus valores, en un inicio; pero ligan sus posibles valores (se especifica el tipo de dato).
2. Mysql traduce, compila, guarda, pero no ejecuta la declaración (faltan los valores).
3. Ejecuta: después, cuando un usuario manda los valores.
v muy veloz.
v previene ataques de inyección sql.
 */?>
