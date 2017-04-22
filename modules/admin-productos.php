<?php
	
	$empresa->AuthUser();
	$empresa->hasPermission($_GET['page']);

	$info = $empresa->Info();
	$smarty->assign('info', $info);
	
	$empresa->Util()->DB()->setQuery('SELECT * FROM usuario');
	$result = $empresa->Util()->DB->GetResult();
	
	$rfc->setEmpresaId($_SESSION['empresaId'], 1);
	$smarty->assign('empresaRfcs', $rfc->GetRfcsByEmpresa());
		
	switch($_GET['section']){
		
		case 'nuevos-productos':
		
				$producto->SetPage($_GET["p"]);
			  	$productos = $producto->GetProductosByRfc();
				
			  	$smarty->assign('productos', $productos);				
				
			  break;	
	}//switch
	
?>