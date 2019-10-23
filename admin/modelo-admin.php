<?php
// modelo-admin.php es el archivo que se conecta a la bd para hacer las consultas
/* compruebo la conexión con la bd
if ($conn->ping()) {
     echo "¡Conectado!";
} else {
     echo "¡No conectado!";
} */

// enlazo al archivo funciones del proyecto admin
include_once 'funciones/funciones.php';
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$id_registro = $_POST['id_registro'];

// crear un nuevo usuario
if ($_POST['registro'] == 'nuevo') {
     // $_POST toma los datos del name="registro" de crear-admin.php
     //die(json_encode($_POST)); // compruebas qe los datos se estén enviando

     // opciones de password_hash con el costo de seguridad
     $opciones = array(
          'cost' => 10
     );

     // hasheo el password con el algoritmo PASSWORD_BCRYPT
     $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);
     //echo $password_hashed;

     // valido la conexión con la bd
     try {
          // prepare statement para insertar info en la bd
          $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?,?,?)");
          $stmt->bind_param('sss', $usuario, $nombre, $password_hashed);
          $stmt->execute();
          $id_registro = $stmt->insert_id;
          if ($id_registro > 0) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_admin' => $id_registro
               );
          } else {
               $respuesta = array(
                    'respuesta' => 'error'
               );
               //die(json_encode($respuesta));
          }
          $stmt->close();
          $conn->close();
     } catch (\Exception $e) {
          echo "Error: " . $e->getMessage();
     }

     die(json_encode($respuesta));
}

// modificar/actualizar info del usuario
if ($_POST['registro'] == 'actualizar') {
     // $_POST toma los datos del name="registro" de crear-admin.php
     //die(json_encode($_POST)); // compruebas qe los datos se estén enviando

     // valido la conexión a bd
     try {
          // hago una query sin el password, si el campo de password está vacío
          if (empty($_POST['password'])) {
               $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ? ");
               $stmt->bind_param("ssi", $usuario, $nombre, $id_registro);
          } else {
               // opciones de seguridad/iteraciones del hash
               $opciones = array(
                   'cost' => 10
               );

               // hasheo el password actualizado
               $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

               // consulto la bd
               $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ? ");
               $stmt->bind_param("sssi", $usuario, $nombre, $hash_password, $id_registro);
          }


          $stmt->execute();
          if ($stmt->affected_rows) {
               $respuesta = array(
                    'respuesta' => 'exito',
                    'id_actualizado' => $stmt->insert_id
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

// eliminar un usuario administrador
if ($_POST['registro'] == 'eliminar') {
     //die(json_encode($_POST));

     $id_borrar = $_POST['id'];

     // valido conexión con la bd
     try {
          $stmt = $conn->prepare("DELETE FROM admins WHERE id_admin = ? ");
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
