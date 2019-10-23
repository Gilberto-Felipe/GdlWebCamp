<?php
// enlazo al archivo funciones del proyecto admin para que conecte con la bd
include_once 'funciones/funciones.php';

$nombre = $_POST['nombre_invitado'];
$apellido = $_POST['apellido_invitado'];
$biografia = $_POST['biografia_invitado'];

$id_registro = $_POST['id_registro']; // id_reistro del Boton-submit Añadir




// crear un nuevo evento
if ($_POST['registro'] == 'nuevo') {
     /*$respuesta = array(
          'post' => $_POST,
          'file' => $_FILES
     );
     die(json_encode($respuesta)); */


     // asigno con una var el lugar donde se subiran los archivos al servidor
     $directorio = "../img/invitados/";

     // valido que el directorio exista
     if (!is_dir($directorio)) {
          mkdir($directorio, 0755, true);
     }

     if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
          $imagen_url = $_FILES['archivo_imagen']['name'];
          $imagen_resultado = 'Se subió correctamente.';

     }else {
               $respuesta = array(
                    'respuesta' => error_get_last()
               );
     }


     try {
          $stmt = $conn->prepare('INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?, ?, ?, ?) ');
          $stmt->bind_param("ssss", $nombre, $apellido, $biografia, $imagen_url);
          $stmt->execute();
          $id_insertado = $stmt->insert_id;
          if ($stmt->affected_rows) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado,
                    'resultado_imagen' => $imagen_resultado
               );
          } else {
               $respuesta = array(
                    'respuesta' => 'error'
               );
          }
          $stmt->close();
          $conn->close();
     } catch (\Exception $e) {
          $respuesta = array(
               'respuesta' => $e->getMessage()
          );
     }
     die(json_encode($respuesta));
}

// modificar/actualizar info del usuario
if ($_POST['registro'] == 'actualizar') {
     // $_POST toma los datos del name
     //die(json_encode($_POST)); // compruebas qe los datos se estén enviando

     // asigno con una var el lugar donde se subiran los archivos al servidor
     $directorio = "../img/invitados/";

     // valido que el directorio exista
     if (!is_dir($directorio)) {
          mkdir($directorio, 0755, true);
     }
     // valido que el directorio se haya movido a su destino
     if (move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio . $_FILES['archivo_imagen']['name'])) {
          $imagen_url = $_FILES['archivo_imagen']['name'];
          $imagen_resultado = 'Se subió correctamente.';

     }else {
               $respuesta = array(
                    'respuesta' => error_get_last()
               );
     }

     // valido la conexión a bd
     try {
          // validar/controlar si se sube un archivo de imagen nuevo
          if ($_FILES['archivo_imagen']['size'] > 0) {
               // se cargó una imagen nueva
               $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url_imagen = ?, editado = NOW() WHERE invitado_id = ? ");
               $stmt->bind_param("ssssi", $nombre, $apellido, $biografia, $imagen_url, $id_registro);
          } else {
               // si no se cambió la imagen
               $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE invitado_id = ? ");
               $stmt->bind_param("sssi", $nombre, $apellido, $biografia, $id_registro);
          }

          // var para conocer el estado del $stmt->execute(): regresa true o false
          $estado = $stmt->execute();

          // comprobar si hay registros afectados en la bd
          if ($estado == true) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $id_registro
               );

          } else {
               $respuesta = array(
                    'respuesta' => 'error'
               );
          }

          $stmt->close();
          $conn->close();
     } catch (\Exception $e) {
          $respuesta = array(
               'respuesta' => $e->getMessage()
          );
     }

     die(json_encode($respuesta));

}

// eliminar un evento
if ($_POST['registro'] == 'eliminar') {
     //die(json_encode($_POST));

     //este id viene de admin-ajax.js->#borar-registro.id
     $id_borrar = $_POST['id'];

     // valido conexión con la bd
     try {
          $stmt = $conn->prepare("DELETE FROM invitados WHERE invitado_id = ? ");
          $stmt->bind_param("i", $id_borrar);
          $stmt->execute();
          if ($stmt->affected_rows) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_eliminado' => $id_borrar
               );
          } else {
               $respuesta = array(
                    'respuesta' => 'error'
               );
          }
     } catch (\Exception $e) {
          $respuesta = array(
               'respuesta' => $e->getMessage()
          );
     }
     die(json_encode($respuesta));
}



/* prueba de comunicación de crear-admin.php a insertar-admin.php
echo "<pre>";
     var_dump($_POST);
echo "</pre>";
*/

/* Documentación
*** password_hash y su algoritmo PASSWORD_BCRYPT es unidireccional: puedes encriptar el password, pero no hay forma de regresar el password encriptado al password original.
Si se te olvida el password original, no se puede hacer nada.
*Si se te olvida, vuelve a reescribir/rehacer el password del administrador.

** Prepare statements previenen la inyección sql

* die() método de php que detiene la ejecución del código debajo de él.
* $stmt->affected_rows: método que te dice si una fila o registro de la bd fue afectado.
* $stmt->insert_id: método que muestra qué id fue insertado en la bd.
* $stmt->bind_result(): método que regresa un resultado de la bd. Suele acompañar al select, porque select arroja resultados.
* password_verify(): método convierte el password al mismo hash y compara el resultado con el password hasheado de la bd, porque una vez que el password se hashea, no se puede revertir. Es un método de un sólo camino.
*json_encode(): Retorna la representación JSON del valor dado.
*empty(): función de php que revisa que una variable no esté vacía. Si está vacía retorna true.
*is_dir(): f de php que revisa que un directorio exista.
*mkdir($archivo, 0755(permisos), true(recursivo)); : f de php para crear un directorio en el servidor. Igual que linux o unix.
*move_uploaded_file(): f de php para mover un archivo de una ubicación temporal a su destino final.

     **unlink() : para eliminar un archivo del servidor -> para las fotos de los invitados
     $file = "test.txt";
     if (!unlink($file))
      {
      echo ("Error deleting $file");
      }
     else
      {
      echo ("Deleted $file");
      }
*/
