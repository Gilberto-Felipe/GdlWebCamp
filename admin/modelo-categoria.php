<?php
// enlazo al archivo funciones del proyecto admin para que conecte con la bd
include_once 'funciones/funciones.php';

$nombre_categoria = $_POST['nombre_categoria'];
$icono = $_POST['icono'];
$id_registro = $_POST['id_registro'];

// crear un nuevo evento
if ($_POST['registro'] == 'nuevo') {
     //die(json_encode($_POST)); // compruebas qe los datos se estén enviando
     try {
          $stmt = $conn->prepare('INSERT INTO categoria_evento (cat_evento, icono) VALUES (?, ?) ');
          $stmt->bind_param("ss", $nombre_categoria, $icono);
          $stmt->execute();
          $id_insertado = $stmt->insert_id;
          if ($stmt->affected_rows) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_insertado' => $id_insertado
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

     // valido la conexión a bd
     try {
          $stmt = $conn->prepare("UPDATE categoria_evento SET cat_evento = ?, icono = ?, editado = NOW() WHERE id_categoria = ? ");
          $stmt->bind_param("ssi", $nombre_categoria, $icono, $id_registro);
          $stmt->execute();

          if ($stmt->affected_rows) {
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

     $id_borrar = $_POST['id']; //este id viene de admin-ajax.js->#borar-registro.id

     // valido conexión con la bd
     try {
          $stmt = $conn->prepare("DELETE FROM categoria_evento WHERE id_categoria = ? ");
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
*/
