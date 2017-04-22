<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa WHERE moduloImpuestos = 'Si' || moduloIsh = 'Si' || moduloAgrario = 'Si' || moduloEscuela = 'Si' || moduloTransporte = 'Si' || moduloIeps = 'Si'  || addendaPepsico = 'Si' || addendaZepto = 'Si' || empresaId != '15' ORDER BY empresaId");
$result = $db->GetResult();

foreach($result as $key => $res)
{
	print_r($res);
}

?>