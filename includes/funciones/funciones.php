<?php
// creo función objeto productos_json. Regresa productos del carrito, paso por valor
function productos_json(&$boletos, &$camisas=0, &$etiquetas=0) {
     $dias = array(0 =>'un_dia', 1=>'pase_completo', 2=>'pase_2dias');

     // borrar precio del array boletos
     unset($boletos['un_dia']['precio']);
     unset($boletos['completo']['precio']);
     unset($boletos['2dias']['precio']);

     // combina los 2 arrays
     $total_boletos = array_combine($dias, $boletos);

     //Agrego camisas, si hay
     $camisas = (int) $camisas;
     if ($camisas > 0):
          $total_boletos['camisas'] = $camisas;
     endif;

     //Agrego etiquetas, si hay
     $etiquetas = (int) $etiquetas;
     if ($etiquetas > 0):
          $total_boletos['etiquetas'] = $etiquetas;
     endif;

     return json_encode($total_boletos);
}


function eventos_json(&$eventos) {
  $eventos_json = array();
  foreach($eventos as $evento):
        $eventos_json['eventos'][] = $evento;
  endforeach;

  return json_encode($eventos_json);
}


// *Paso por valor: la información de la variable se almacenan en una dirección de memoria diferente al recibirla en la funcion, por lo tanto si el valor de esa variable cambia no afecta la variable original, solo se modifica dentro del contexto de la función.
// *Paso por referencia: la variable que se recibe como parámetro en la función apunta exactamente a la misma dirección de memoria que la variable original por lo que si dentro de la función se modifica su valor también se modifica la variable original.
// *unset(): func que elimina o 1 variable o 1 elemento de un array
