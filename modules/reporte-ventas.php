<?php
	
	$empresa->AuthUser();
	
	session_start();
	
	$_SESSION['pgRepVtas'] = $_GET['p'];
	
	$info = $empresa->Info();
	$smarty->assign("info", $info);
	
	$usuario->setUsuarioId($_SESSION['usuarioId']);
	$infoUsuario = $usuario->Info();

	$empresa->hasPermission($_GET['page']);
	$comprobantes = array();
	//$venta->setSucursalId($infoUsuario['sucursalId']);
	$venta->SetPage($_GET["p"]);
	$comprobantes = $venta->GetNotasVenta();
			
	if($comprobantes)
		$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);
	
	$total = 0;
	$subtotal = 0;
	$iva = 0;
	$isr = 0;

  $comprobantesAll = $venta->GetNotasVenta(false);
	if(count($comprobantesAll["items"]) > 0){
		foreach($comprobantesAll["items"] as $res){
			$total += $res['total'];
			$subtotal += $res['subtotal'];
			$iva += $res['iva'];
			$totalPayments += $res['payments_noformat'];
		}
	}

	$debt = number_format($total-$totalPayments,2,'.',',');
	$totalPayments = number_format($totalPayments,2,'.',',');
	$total = number_format($total,2,'.',',');
	$subtotal = number_format($subtotal,2,'.',',');
	$iva = number_format($iva,2,'.',',');
	$isr = number_format($isr,2,'.',',');
	
	$smarty->assign('comprobantes',$comprobantes);
	$smarty->assign('total',$total);
	$smarty->assign('subtotal',$subtotal);
	$smarty->assign('iva',$iva);
	$smarty->assign('isr',$isr);
	$smarty->assign('totalPayments',$totalPayments);
	$smarty->assign('debt',$debt);
	
				$id_rfc = $sucursal->getRfcActive();
			$sucursal->setRfcId($id_rfc);
			$sucursales = $sucursal->GetSucursalesByRfc();
			$smarty->assign('sucursales',$sucursales);
			for($k=1; $k<=12; $k++){
				$card['id'] = $k;
				$card['nombre'] = ucfirst($util->ConvertirMes($k));
				
				$meses[$k] = $card;
				
			}//for
			
			$smarty->assign('meses',$meses);

?>