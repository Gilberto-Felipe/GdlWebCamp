<?php

// validación de acción login-admin
if (isset($_POST['login-admin'])) {
     $usuario = $_POST['usuario'];
     $password = $_POST['password'];
     // $_POST toma los datos del name="login-admin" de login-admin.php
     //die(json_encode($_POST)); // compruebo que los datos se envían
     //echo json_encode($_POST['usuario']);

     try {
          // enlazo al archivo funciones del proyecto admin
          include_once 'funciones/funciones.php';

          // prepare statement para consultar bd
          $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ?;");
          $stmt->bind_param("s", $usuario);
          $stmt->execute();

          $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin, $editado, $nivel);
          if ($stmt->affected_rows) {
               $existe = $stmt->fetch();
               if ($existe) {
                    if (password_verify($password, $password_admin)) {

                         //iniciar sesión
                         session_start();
                         $_SESSION['usuario'] = $usuario_admin;
                         $_SESSION['nombre'] = $nombre_admin;
                         $_SESSION['id'] = $id_admin;
                         $_SESSION['nivel'] = $nivel;
                         $respuesta = array(
                              'respuesta' => 'correcto',
                              'usuario' => $nombre_admin
                         );
                    } else {
                         $respuesta = array(
                              'respuesta' => 'error'
                         );
                    }
               } else {
                    $respuesta = array(
                         'respuesta' => 'error'
                    );
               }
          }
          $stmt->close();
          $conn->close();
     } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
     }

     die(json_encode($respuesta));
}
