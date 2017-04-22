<?php
	
	$cliente->AuthCliente();

	$comprobantes = array();
	$comprobante->SetPage($_GET["p"]);
	$result = $comprobante->GetComprobantesByUser();

	if($result)
	{
		$comprobantes["items"] = $util->DecodeResult($result["items"]);
	}
	$comprobantes["pages"] = $result["pages"];
	
	$total = 0;
	$subtotal = 0;
	$iva = 0;
	$isr = 0;
	
	if(count($comprobantes["items"]) > 0){
		foreach($comprobantes["items"] as $res){
			if($res["status"] == 0)
			{
				continue;
			}
			if($res["tipoDeComprobante"] == "ingreso")
			{
				$total += $res['total'];
				$subtotal += $res['subTotal'];
				$iva += $res['ivaTotal'];
				$isr += $res['isrRet'];
				$payments += $res['payments_noformat'];
			}
			else
			{
				$total -= $res['total'];
				$subtotal -= $res['subTotal'];
				$iva -= $res['ivaTotal'];
				$isr -= $res['isrRet'];
				$payments -= $res['payments_noformat'];
			}
		}
	}

	$debt = number_format($total-$payments,2,'.',',');
	$payments = number_format($payments,2,'.',',');
	$total = number_format($total,2,'.',',');
	$subtotal = number_format($subtotal,2,'.',',');
	$iva = number_format($iva,2,'.',',');
	$isr = number_format($isr,2,'.',',');
		
	$smarty->assign('comprobantes',$comprobantes);
	$smarty->assign('total',$total);
	$smarty->assign('subtotal',$subtotal);
	$smarty->assign('iva',$iva);
	$smarty->assign('isr',$isr);
	$smarty->assign('payments',$payments);
	$smarty->assign('debt',$debt);
	
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
	
	$empresa->Util()->DB()->setQuery("SELECT * FROM empresa WHERE empresaId = ".$_SESSION["empresaId"]." LIMIT 1");			
	$vencimiento = $empresa->Util()->DB()->GetRow();
	$vencimiento_move = $vencimiento;
	$smarty->assign("vencimiento", $vencimiento);
	
	$vencimiento = strtotime($vencimiento["vencimiento"]) - (3600 * 24 * 30);
	$oneMonth = time();
	
	if($vencimiento < $oneMonth)
	{
		$empresa->Util()->setError(20022, "complete");
		$empresa->Util()->PrintErrors();
		
		$smarty->assign("renew", 1);
	}	
	
	$vencimiento = strtotime($vencimiento_move["vencimiento"]);
	$now = time() - (3600 * 24 * 7);
	
	if($vencimiento < $now)
	{
		header("Location:".WEB_ROOT."/activar");
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
?>