<?php
$empresa->AuthUser();
//$empresa->hasPermission($_GET['page']);

$info = $empresa->Info();
$smarty->assign('info', $info);

$ventas = $empresa->Ventas();
$smarty->assign('ventas', $ventas);

//print_r($info);
?>