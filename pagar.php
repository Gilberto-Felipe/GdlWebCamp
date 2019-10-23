<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

// condición para que sólo se acceda pág pagar.php dando click en boton(submit) Total
if (!isset($_POST['submit'])) {
     exit('Hubo un error!');
}

/*// prueba de que index se comnica con pagar
echo "<pre>";
     var_dump($_POST);
echo "</pre>"; */

// namespace/ruta de las clases de paypal
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// enlazo pagar.php con las clases de paypal que están contenidas en paypal.php
require 'includes/paypal.php';

//
if(isset($_POST['submit'])): // validación
     // manejar variables de validación
     $nombre = $_POST['nombre'];
     $apellido = $_POST['apelido'];
     $email = $_POST['email'];
     $regalo = $_POST['regalo'];
     $total = $_POST['total_pedido'];
     $fecha = date('Y-m-d H:i:s');

     // pedidos
     $boletos = $_POST['boletos'];
     $numero_boletos = $boletos; // copia de boletos

     $pedidoExtra = $_POST['pedido_extra'];
     $camisas = $_POST['pedido_extra']['camisas']['cantidad'];
     $precioCamisas = $_POST['pedido_extra']['camisas']['precio'];
     $etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];
     $precioEtiquetas = $_POST['pedido_extra']['etiquetas']['precio'];

     // llamo al archivo funciones.php
     include_once 'includes/funciones/funciones.php';
     $pedido = productos_json($boletos, $camisas, $etiquetas); // siempre q utilices 1 fun con return debes asignarla a una var.

     // Eventos
     $eventos = $_POST['registro'];
     $registro = eventos_json($eventos);

/* Prueba
     echo "<pre>";
          var_dump($pedidoExtra);
     echo "</pre>";
     exit;*/

//Prepared statements para insertar en la bd
try {
    require_once('includes/funciones/bd_conexion.php'); // es un include_once, mas exigente.
    //Preparo y ligo los stmt (statements)
    $stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $nombre, $apellido, $email, $fecha, $pedido, $registro, $regalo, $total);
    $stmt->execute();
    $ID_registro = $stmt->insert_id;
    $stmt->close();
    $conn->close();
    //header('Location: validar_registro.php?exitoso=1');
} catch (\Exception $e) {
    $error = $e->getMessage();
}
endif;

// Instancio/creo los objetos de paypal
// creo el método de pago
$compra = new Payer();
$compra->setPaymentMethod('paypal');

// genero los artículos del pedido
$articulo = new Item();
$articulo->setName($producto) /*$producto*/
          ->setCurrency('USD')
          ->setQuantity(1)
          ->setPrice($boletos['precio']); /*$precio*/

$i = 0;
$arreglo_pedido = array();
foreach ($numero_boletos as $key => $value) {
     if ((int) $value['cantidad'] > 0) {
          ${"articulo$i"} = new Item();
          $arreglo_pedido[] = ${"articulo$i"};
          ${"articulo$i"}->setName('Pase: ' . $key)
                         ->setCurrency('USD')
                         ->setQuantity( (int) $value['cantidad'] )
                         ->setPrice( (int) $value['precio'] );
          $i++;
     }
}

//echo $articulo->getName();

foreach ($pedidoExtra as $key => $value) {
     if ((int) $value['cantidad'] > 0) {
          if ($key === 'camisas') {
               $precio = (float) $value['precio'] * .93;
          }else {
               $precio = (int) $value['precio'];
          }
          ${"articulo$i"} = new Item();
          $arreglo_pedido[] = ${"articulo$i"};
          ${"articulo$i"}->setName('Extras: ' . $key)
                         ->setCurrency('USD')
                         ->setQuantity( (int) $value['cantidad'] )
                         ->setPrice($precio);
          $i++;
     }
}
//echo $articulo0->getName();

// guardo la lista de artículos paypal
$listaArticulos = new ItemList();
$listaArticulos->setItems($arreglo_pedido); /*$pedidoExtra*/

/* pruebo
echo "<pre>";
     var_dump($listaArticulos);
echo "</pre>"; */

$cantidad = new Amount();
$cantidad->setCurrency('USD')
          ->setTotal($total);

//echo $total;

$transaccion = new Transaction();
$transaccion->setAmount($cantidad)
          ->setItemList($listaArticulos)
          ->setDescription('Pago GDLWEBCAMP')
          ->setInvoiceNumber($ID_registro);

//echo $transaccion->getInvoiceNumber();

// Redirecciono a una nueva url al finalizar o cancelar el pago
$redireccionar = new RedirectUrls();
$redireccionar->setReturnUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}")
               ->setCancelUrl(URL_SITIO . "/pago_finalizado.php?&id_pago={$ID_registro}");

//echo $redireccionar->getReturnUrl();

//Comprobar que estamos tomando/leyendo los datos de la url
$pago = new Payment();
$pago->setIntent("sale")
     ->setPayer($compra)
     ->setRedirectUrls($redireccionar)
     ->setTransactions(array($transaccion));

try {
     $pago->create($apiContext);
} catch (PayPal\Exception\PayPalConnectionException $pce) {
     echo "<pre>";
          print_r(json_decode($pce->getData()));
          exit;
     echo "</pre>";
}

$aprobado = $pago->getApprovalLink();
// creo un enlace a $aprobado
header("Location: {$aprobado}");
