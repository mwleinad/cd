<?php
$info = $user->Info();


$smarty->assign("user", $info);

	$empresa->Util()->DB()->setQuery("SELECT * FROM empresa WHERE empresaId = ".$_SESSION["empresaId"]." LIMIT 1");			
	$vencimiento = $empresa->Util()->DB()->GetRow();
	$vencimiento_move = $vencimiento;
	$smarty->assign("vencimiento", $vencimiento);

?>