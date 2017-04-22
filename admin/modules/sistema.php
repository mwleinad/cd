<?php
	
	$empresa->AuthUser();
	
	$info = $empresa->Info();
	$smarty->assign("info", $info);

	$empresa->Util()->DB()->setQuery("SELECT * FROM usuario");
	$result = $empresa->Util()->DB->GetResult();

	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());

	switch($_GET["section"]){
	
		case "nueva-factura":
			
			$producto->CleanConceptos();
			$ivas = $main->ListIvas();
			$smarty->assign("ivas", $ivas);
			$retIsrs = $main->ListRetIsr();
			$smarty->assign("retIsrs", $retIsrs);
			$retIvas = $main->ListRetIva();
			$smarty->assign("retIvas", $retIvas);
			$tiposDeMoneda = $main->ListTipoDeMoneda();
			$smarty->assign("tiposDeMoneda", $tiposDeMoneda);
			$comprobantes = $main->ListTiposDeComprobantesValidos();
			$smarty->assign("comprobantes", $comprobantes);		
			$sucursal->setRfcId($rfc->getRfcActive());
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$sucursales = $sucursal->GetSucursalesByRfc();
			$smarty->assign("sucursales", $sucursales);		
			$excentoIva = $main->ListExcentoIva();
			$smarty->assign("excentoIva", $excentoIva);		
			
			break;
			
		case 'consultar-facturas':
			
			$comprobantes = $comprobante->GetComprobantesByRfc();			
			
			$total = 0;
			foreach($comprobantes as $res)
				$total += $res['total'];
			
			$total = number_format($total,2,'.',',');
				
			$smarty->assign('comprobantes',$comprobantes);
			$smarty->assign('total',$total);
			
			for($k=1; $k<=12; $k++){
				$card['id'] = $k;
				$card['nombre'] = ucfirst($util->ConvertirMes($k));
				
				$meses[$k] = $card;
				
			}//for
			
			$smarty->assign('meses',$meses);
			
			$tipos_comprobantes = $main->ListTiposDeComprobantes();
			$smarty->assign('tipos_comprobantes',$tipos_comprobantes);
			
			$id_rfc = $sucursal->getRfcActive();
			$sucursal->setRfcId($id_rfc);
			$sucursales = $sucursal->GetSucursalesByRfc();
			$smarty->assign('sucursales',$sucursales);
		
			break;
	
	}//switch
?>