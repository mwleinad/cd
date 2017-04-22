<?php
	
	$empresa->AuthUser();
	$info = $empresa->Info();
	$smarty->assign("info", $info);

	$empresa->Util()->DB()->setQuery("SELECT * FROM usuario");
	$result = $empresa->Util()->DB->GetResult();

	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());

			$empresa->hasPermission("nueva-factura");
			$producto->CleanConceptos();
			$producto->CleanImpuestos();
			
			if(isset($_GET['id']))
			{
				$db->setQuery("SELECT * FROM usuario WHERE usuarioId = '".$_GET['id']."'");
				$miUsuario = $db->GetRow();

				$miNomina = unserialize(urldecode($miUsuario["nomina"]));
				
				$_SESSION["percepciones"] = $miNomina[1]["percepciones"];
				$smarty->assign("percepciones", $_SESSION["percepciones"]);

				$_SESSION["otrosPagos"] = $miNomina[1]["otrosPagos"];
				$smarty->assign("otrosPagos", $_SESSION["otrosPagos"]);

				$_SESSION["deducciones"] = $miNomina[1]["deducciones"];
				$smarty->assign("deducciones", $_SESSION["deducciones"]);

				$_SESSION["incapacidades"] = $miNomina[1]["incapacidades"];
				$smarty->assign("incapacidades", $_SESSION["incapacidades"]);

				$_SESSION["horasExtras"] = $miNomina[1]["horasExtras"];
				$smarty->assign("horasExtras", $_SESSION["horasExtras"]);

				$_SESSION["conceptos"] = $miNomina[1]["conceptos"];
				$smarty->assign("conceptos", $_SESSION["conceptos"]);
				
				$totalDesglosado = $nomina->GetTotalDesglosado($miNomina[0], $miNomina[1]);
				if($totalDesglosado){
					foreach($totalDesglosado as $key => $total)
					{
						$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
					}
				}
				$smarty->assign("totalDesglosado", $totalDesglosado);				
				$smarty->assign("post", $miNomina[0]);				
			}

			$ivas = $main->ListIvas();
			$smarty->assign("ivas", $ivas);
			$retIsrs = $main->ListRetIsr();
			$smarty->assign("retIsrs", $retIsrs);
			$retIvas = $main->ListRetIva();
			$smarty->assign("retIvas", $retIvas);
			$tiposDeMoneda = $main->ListTipoDeMoneda();
			$smarty->assign("tiposDeMoneda", $tiposDeMoneda);
			$comprobantes = $main->ListTiposDeComprobantesValidosBySucursalNomina();
			$smarty->assign("comprobantes", $comprobantes);		
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
			$excentoIva = $main->ListExcentoIva();
			$smarty->assign("excentoIva", $excentoIva);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			
	$empresa->Util()->DB()->setQuery("SELECT * FROM empresa WHERE empresaId = ".$_SESSION["empresaId"]." LIMIT 1");			
	$vencimiento = $empresa->Util()->DB()->GetRow();
	$vencimiento_move = $vencimiento;
	$smarty->assign("vencimiento", $vencimiento);
	
	$vencimiento = strtotime($vencimiento["venNomina"]) - (3600 * 24 * 30);
	$oneMonth = time();
	
	if($vencimiento < $oneMonth)
	{
		$empresa->Util()->setError(20022, "complete");
		$empresa->Util()->PrintErrors();
		
		$smarty->assign("renew", 1);
	}	
	
	$vencimiento = strtotime($vencimiento_move["venNomina"]);
	$now = time() - (3600 * 24 * 7);
	
	if($vencimiento < $now)
	{
		$smarty->assign("expired", 1);
	}
	
	$id_rfc = $rfc->getRfcActive();
	$rfc->setRfcId($id_rfc);
	$certNuevo = $rfc->GetCertificadoByRfc();
	$smarty->assign("certNuevo", $certNuevo);

	$folios->setIdRfc($id_rfc);
	$noFolios  = count($listFolios = $folios->GetFoliosByRfc());
	$smarty->assign('noFolios', $noFolios);	
	
	$qrs = 0;
	foreach($listFolios as $key => $value)
	{
		if($value["qr"] != "")
		{
			$qrs++;
		}
	}
	$smarty->assign('qrs', $qrs);	
	
	$cliente->GetCountClientesByActiveRfc();
	$smarty->assign('countClientes', $cliente->GetCountClientesByActiveRfc());	
	
	//tipos de percepcion
	$db->setQuery("SELECT * FROM tipoPercepcion ORDER BY clavePercepcion ASC");
	$tiposPercepcion = $db->GetResult();
	$smarty->assign('tiposPercepcion',$tiposPercepcion);

	//tipos de otros pagos
	$db->setQuery("SELECT * FROM tipoOtroPago ORDER BY claveOtroPago ASC");
	$tiposOtroPago = $db->GetResult();
	$smarty->assign('tiposOtroPago',$tiposOtroPago);
	
	//tipos de percepcion
	$db->setQuery("SELECT * FROM tipoDeduccion ORDER BY claveDeduccion ASC");
	$tiposDeduccion = $db->GetResult();
	$smarty->assign('tiposDeduccion',$tiposDeduccion);

	//tipos de incapacidad
	$db->setQuery("SELECT * FROM tipoIncapacidad ORDER BY claveIncapacidad ASC");
	$tiposIncapacidad = $db->GetResult();
	$smarty->assign('tiposIncapacidad',$tiposIncapacidad);
	
	if(!isset($_GET['id']))
	{
		unset($_SESSION["percepciones"]);
		unset($_SESSION["otrosPagos"]);
		unset($_SESSION["deducciones"]);
		unset($_SESSION["incapacidades"]);
		unset($_SESSION["horasExtras"]);
	}
	
	if(!$comprobantes)
	{
		$smarty->assign('faltaSerieNomina', true);
	}
	
	
?>