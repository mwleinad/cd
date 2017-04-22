<?php
	
	$empresa->AuthUser();
	//$empresa->hasPermission($_GET['page']);

	$info = $empresa->Info();
	$smarty->assign('info', $info);
	
				$proveedor->SetPage($_GET["p"]);
			  	$proveedores = $proveedor->GetProveedores();
				
			  	$smarty->assign('proveedores', $proveedores);				
?>