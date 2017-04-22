<?php
//print_r($_SESSION);EXIT;
//print_r($_SESSION);EXIT;

//$usuario->AuthAdmin();
//exit;

$ordenes = $ordenes->OrdenesLista();
//print_r($ordenes);
$usuario->setIdUsuario($_SESSION['loginKey']);
$__usuario = $usuario->EnumerateUsuario();

$socios = $usuario->Enumerate();
 
//echo "<pre>";print_r($__usuario);exit;


$data = array();
foreach($ordenes as $orden)
{
	$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
}
//print_r($data);
$smarty->assign("socios",$socios);
$smarty->assign("roleId",$_SESSION['roleId']);
$smarty->assign("info2",$__usuario);
$smarty->assign('data', $data);
$smarty->assign('orden', $ordenes);


?>