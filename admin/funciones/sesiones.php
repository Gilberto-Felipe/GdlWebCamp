<?php
// revisa que haya una sesión autenticada
function usuario_autenticado() {
     if (!revisar_usuario()) {
          header('Location:login.php');
          exit();
     }
}

// redirecciona al login.php, si no hay una sesión iniciada
function revisar_usuario() {
     return isset($_SESSION['usuario']);
}

// inicio la sesión
session_start();
usuario_autenticado();
