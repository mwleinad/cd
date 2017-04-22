<?php
include_once("config.php");
include_once("libraries.php");

//recordatorios de vencimiento
$lista = $vencimiento->ConsultaVencimiento();
 if($lista)
 {
	 foreach($lista as $data)
	 {
		 $vencimiento->setId($data['empresaId']);
		 $vencimiendo->GuardaVencimientos();
	 }
 }


//suspencion clientes con mas de 7 dias
$suspencion = $vencimiento->ConsultaSuspencion();
 if($suspencion)
 {
	 foreach($suspencion as $data)
	 {
		 $vencimiento->setId($data['empresaId']);
		 $vencimiendo->SuspenderVencimientos();
	 }
 }

?>