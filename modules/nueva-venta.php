<?php
	$empresa->AuthUser();
	$empresa->hasPermission($_GET['page']);
	$excentoIva = $main->ListExcentoIva();
	$ivas = $main->ListIvas();
	
	$smarty->assign("excentoIva",$excentoIva);
	$smarty->assign("iva",$ivas[0]);
	
			$sucursal->setRfcId($rfc->getRfcActive());
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);

			$resSucursales = $sucursal->GetSucursalesByRfc();
			
			foreach($resSucursales as $key => $res)
			{
				if($_SESSION["sucursalId"] != $res["sucursalId"] && $_SESSION["sucursalId"] > 0)
				{
					unset($resSucursales[$key]);
				}
			}	
			$resSuc = $util->DecodeUrlResult($resSucursales);
			$sucursales = $resSuc;
			$smarty->assign("sucursales", $sucursales);		
			
			unset($_SESSION["conceptos"]);
			
?>