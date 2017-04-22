<?php

	$empresa->AuthUser();
	$empresa->hasPermission($_GET['page']);
	
	$info = $empresa->Info();
	$smarty->assign("info", $info);
		
	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());
	
	$empUsers = $usuario->GetUsuariosByEmpresa($_SESSION["empresaId"]);
	//$empUsers = $util->DecodeResult($empUsers);
	
	$smarty->assign("empresaUsuarios", $empUsers);

?>