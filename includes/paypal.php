<?php

require 'paypal/autoload.php';

define('URL_SITIO', 'http://127.0.0.1/gil_gdlwebcamp/');


$apiContext = new \PayPal\Rest\ApiContext(
     new \PayPal\Auth\OAuthTokenCredential(
          'AY_LXa15gZ6H42gTFo-SmojRhrNPXaKwppTG5b-iTwKb0ZdLSOxxA2cmxb8On7S5Q5O571uEvjzv0wyg', // Cliente ID
          'EIBXyQpkUQCAOWkHbPLfvVwjlW4hQ_EzVaOCq1d7yQxC1NKkAYsMg8Et3agr2XOxq6axQCyYUHzk3lNh'// Secret
          )
);





/* Documentación
*define(): Define una constante con nombre, puede ser de tipo resource (p.e. enlace a un recurso externo).

*/
