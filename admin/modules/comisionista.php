<?php
$usuario->AuthAdmin();


$referido = $comisionista->showreferidos();
$comisionistaRes = $comisionista-> OrdenesLista();

$data2 = array();
foreach($referido as $orden)
{
	//print_r($orden);
	$data2["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
}

$smarty->assign('data2', $data2);
$smarty->assign('referido', $referido);





$data = array();
foreach($comisionistaRes as $orden)
{
	//print_r($orden);
	$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
}

$smarty->assign('data', $data);



$smarty->assign('comisionista', $comisionistaRes);

?>