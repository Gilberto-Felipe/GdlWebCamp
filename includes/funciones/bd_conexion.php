<?php
     $conn = new mysqli('localhost', 'root', '', 'gdlwebcamp');
     $conn->query("SET NAMES 'utf8'");

     if ($conn->connect_error) { // si hay un error en la conexión
          echo "Error: " . $error = $conn->connect_error; //imprime error de la conexión
     }
 ?>
