<?php

	$empresa->AuthUser();
	$empresa->hasPermission($_GET['page']);
	
	$info = $empresa->Info();	
	
	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
			
	$cliente->setEmpresaId($_SESSION['empresaId'],1);	
	$cliente->SetPage($_GET["p"]);
	$clientes = $cliente->GetClientesByActiveRfc();
	
	$smarty->assign("clientes", $clientes);
	$smarty->assign("info", $info);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());
	$smarty->assign("empresaUsuarios", $usuario->GetUsuariosByEmpresa($_SESSION["empresaId"]));
		
?>