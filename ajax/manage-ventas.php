<?php 

	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');
	
	session_start();
	
	$smarty->assign("permisos",$_SESSION['permisos2']);
	$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

	switch($_POST['type']){
	
		case 'ticketsFacturar':
			unset($_SESSION['ticketsId']);
			$ticketsFacturar = $_POST['ticketsFacturar'];
			$ticketsFacturar = explode("&",$ticketsFacturar);
			$_SESSION['ticketsId'] = array();
			foreach($ticketsFacturar as $key => $resTicket)
			{
				$ticket = explode("=",$resTicket);
				$_SESSION['ticketsId'][] = $ticket[1];
			}
			
			if(count($_SESSION['ticketsId']) > 0)
				echo "ok[#]";
			else
				echo "fail[#]";
				
			print_r($_SESSION['ticketsId']);
		break;
		
		case 'listPaymentsPdf':
		
			include(DOC_ROOT.'/pdf/payments.php');
			
		break;

		case 'editarConceptos':
		
			$id_comprobante = $_POST['id'];
			$venta->setVentaId($id_comprobante);
			$infoComprobante =  $venta->GetInfoVenta($id_comprobante);
			$smarty->assign('infoComprobante', $infoComprobante);
			
			$productos = $venta->GetProductos();
			$smarty->assign('productos', $productos);
			$smarty->assign('DOC_ROOT', DOC_ROOT);					
			$smarty->display(DOC_ROOT.'/templates/boxes/editar-concepto-popup.tpl');
			
			break;					
			
		case 'addPayment':
		
			$id_comprobante = $_POST['id'];
			$venta->setVentaId($id_comprobante);
			$infoComprobante =  $venta->GetInfoVenta($id_comprobante);
			$payment->setComprobanteId($id_comprobante);
			$payments = $payment->Enumerate($id_comprobante);
			$smarty->assign('payments', $payments);
			$smarty->assign('infoComprobante', $infoComprobante);
			$smarty->assign('date', date("Y-m-d"));
			$smarty->assign('DOC_ROOT', DOC_ROOT);					
			$smarty->display(DOC_ROOT.'/templates/boxes/add-payment-popup.tpl');
			
			break;
		case 'saveEditarConcepto':
			if(!$venta->UpdateConceptos($_POST["importe"]))
			{
			}
			else
			{
				//Ini Comprobantes
								
				$usuario->setUsuarioId($_SESSION['usuarioId']);
				$infoUsuario = $usuario->Info();
	
				$comprobantes = array();
				$venta->setSucursalId($infoUsuario['sucursalId']);
				$venta->SetPage($_SESSION['pgRepVtas']);
				$comprobantes = $venta->GetNotasVenta();
			
				if($comprobantes)
					$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);
				
				$total = 0;
				$subtotal = 0;
				$iva = 0;
				$isr = 0;
			
				if(count($comprobantes["items"]) > 0){
					foreach($comprobantes["items"] as $res){
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
				
				//Fin Comprobantes
				
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$payments = $payment->Enumerate($_POST["comprobanteId"]);				
				$smarty->assign("payments", $payments);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/payments.tpl');
				echo "[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/resumen-ventas.tpl');
				echo "[#]";
				$smarty->display(DOC_ROOT.'/templates/lists/notas_venta.tpl');
				echo "[#]";
				echo $_POST["comprobanteId"];
			}
			
			break;		
		case 'saveAddPayment':
			$payment->setComprobanteId($_POST["comprobanteId"]);
			$payment->setAmount($_POST["importe"]);
			$payment->setMetodoPago($_POST["metodoPago"]);
			$payment->setFecha($_POST["fecha"]);
			if(isset($_POST["generarComprobantePago"])) {
				$payment->setGenerarComprobantePago(true);
			}

			if(!$payment->AddPayment())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				//Ini Comprobantes
								
				$usuario->setUsuarioId($_SESSION['usuarioId']);
				$infoUsuario = $usuario->Info();
	
				$comprobantes = array();
				$venta->setSucursalId($infoUsuario['sucursalId']);
				$venta->SetPage($_SESSION['pgRepVtas']);
				$comprobantes = $venta->GetNotasVenta();
			
				if($comprobantes)
					$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);
				
				$total = 0;
				$subtotal = 0;
				$iva = 0;
				$isr = 0;
			
				if(count($comprobantes["items"]) > 0){
					foreach($comprobantes["items"] as $res){
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
				
				//Fin Comprobantes
				
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$payments = $payment->Enumerate($_POST["comprobanteId"]);				
				$smarty->assign("payments", $payments);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/payments.tpl');
				echo "[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/resumen-ventas.tpl');
				echo "[#]";
				$smarty->display(DOC_ROOT.'/templates/lists/notas_venta.tpl');
				echo "[#]";
				echo $_POST["comprobanteId"];
			}
			
			break;
		
		case 'deletePayment':
		
			$payment->setPaymentId($_POST["id"]);
			$paymentInfo = $payment->Info();
			$payment->DeletePayment();
			
			//Ini Comprobantes
								
			$usuario->setUsuarioId($_SESSION['usuarioId']);
			$infoUsuario = $usuario->Info();

			$comprobantes = array();
			$venta->setSucursalId($infoUsuario['sucursalId']);
			$venta->SetPage($_SESSION['pgRepVtas']);
			$comprobantes = $venta->GetNotasVenta();
		
			if($comprobantes)
				$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);
			
			$total = 0;
			$subtotal = 0;
			$iva = 0;
			$isr = 0;
		
			if(count($comprobantes["items"]) > 0){
				foreach($comprobantes["items"] as $res){
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
			
			//Fin Comprobantes
			
			echo "ok[#]";
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			echo "[#]";
			$payment->setComprobanteId($paymentInfo["notaVentaId"]);
			$payments = $payment->Enumerate();
			$smarty->assign("payments", $payments);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/lists/payments.tpl');
			echo "[#]";
			$smarty->display(DOC_ROOT.'/templates/boxes/resumen-ventas.tpl');
			echo "[#]";
			$smarty->display(DOC_ROOT.'/templates/lists/notas_venta.tpl');
			echo "[#]";
			echo $paymentInfo["notaVentaId"];
			break;
			
		case 'showDetails':
		
			$id_comprobante = $_POST['id_item'];			
			
			$compInfo = $comprobante->GetInfoComprobante($id_comprobante);
			$user->setUserId($compInfo['userId'],1);
			$usr = $user->GetUserInfo();
			$nomRfc = $usr['rfc'];
						
			$serie = $compInfo['serie'];
			$folio = $compInfo['folio'];
			
			$smarty->assign('id_comprobante', $id_comprobante);
			$smarty->assign('rfc', $nomRfc);
			$smarty->assign('serie', $serie);
			$smarty->assign('folio', $folio);
			$smarty->assign('DOC_ROOT', DOC_ROOT);		
			
			$info = $user->Info();
			$smarty->assign("info", $info);	
			$smarty->display(DOC_ROOT.'/templates/boxes/acciones-factura-popup.tpl');
			
			break;
		
		case 'cancelar_div':
		
			$id_venta = $_POST['id_item'];
			$venta= new venta();			
			$venta->setVentaId($id_venta);
			$compInfo = $venta->Info();
			$user->setUserId($compInfo['userId'],1);
			$usr = $user->GetUserInfo();
			$nomRfc = $usr['rfc'];
			$serie = $compInfo['serie'];
			$folio = $compInfo['folio'];
			$status = $compInfo['status'];

			$smarty->assign('status', $status);
			$smarty->assign('id_comprobante', $id_comprobante);
			$smarty->assign('rfc', $nomRfc);
			$smarty->assign('serie', $serie);
			$smarty->assign('folio', $folio);
			$smarty->assign('id_venta', $id_venta);
			$smarty->assign('DOC_ROOT', DOC_ROOT);			
			$smarty->display(DOC_ROOT.'/templates/boxes/cancelar-venta-popup.tpl');
			
			break;
//

      
		case 'cancelar_venta':
			$venta->setVentaId($_POST['id_comprobante']);
			$venta->setMotivoCancelar($_POST['motivo']);
			$venta->setStatus(0);
 			if(!$venta->cancelarVenta()){
					echo 'fail[#]';
					$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				}
			else{
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');				
				echo '[#]';	
				$_SESSION['pgRepVtas'] = $_GET['p'];
				$info = $empresa->Info();
				$smarty->assign("info", $info);
				$usuario->setUsuarioId($_SESSION['usuarioId']);
				$infoUsuario = $usuario->Info();
				//$empresa->hasPermission($_GET['page']);
				$comprobantes = array();
				$venta->setSucursalId($infoUsuario['sucursalId']);
				$venta->SetPage($_GET["p"]);
				$comprobantes = $venta->GetNotasVenta();
			
				if($comprobantes)
					$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);
	
				$total = 0;
				$subtotal = 0;
				$iva = 0;
				$isr = 0;

				if(count($comprobantes["items"]) > 0){
					foreach($comprobantes["items"] as $res){
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
				//$smarty->assign('folios', $folios->GetFoliosByEmpresa());
				//$smarty->assign('DOC_ROOT', DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/notas_venta.tpl');	
					
				
				}
			
			
			
			break;			//
					
		case 'cancelar_factura':
		
			$empresa->setComprobanteId($_POST['id_comprobante']);
			$empresa->setMotivoCancelacion($_POST['motivo']);
															
			if(!$empresa->CancelarComprobante()){
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{				
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');				
				echo '[#]';				
				//$smarty->assign('folios', $folios->GetFoliosByEmpresa());
				//$smarty->assign('DOC_ROOT', DOC_ROOT);
				//$smarty->display(DOC_ROOT.'/templates/lists/folios.tpl');				
			}//else
			break;			
		
		case 'buscar':
				$usuario->setUsuarioId($_SESSION['usuarioId']);
				$infoUsuario = $usuario->Info();
				$comprobantes = array();
				
				$venta->SetPage($_GET["p"]);
				$result = $venta->GetNotasVenta(false);
			
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
					foreach($comprobantes["items"] as $key => $res){
						$total += $res['total'];
						$subtotal += $res['subtotal'];
						$iva += $res['iva'];
						$payments += $res['payments_noformat'];
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
				$smarty->assign('totalPayments',$payments);
				$smarty->assign('debt',$debt);	
				
				$total = 0;
				foreach($comprobantes as $res){
					$total += $res['total'];
				}
				
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/resumen-ventas.tpl');
				echo '[#]';
								
				$smarty->assign('DOC_ROOT', DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/notas_venta.tpl');
				
			break;	
		
		case 'enviar_email':
		
			$id_comprobante = $_POST['id_comprobante'];
			
			$user->SendComprobante($id_comprobante);
			
			echo 'ok[#]';
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
		
			break;
			
		case 'exportar':
				
				foreach($_POST as $key => $val){
					$values[$key] = $val;
				}
				
				$comprobantes = array();
				$comprobantes = $venta->GetNotasVenta();		
				print_r($comprobantes);		
				//$smarty->assign('comprobantes',$comprobantes);
				

				$data .= "ID,Total,Identificador,Serie,Folio,Estatus Factura,Fecha,Estatus Ticket,Subtotal,IVA,Facturado,Pagos,Saldo,Estatus Pago \n";
				foreach($comprobantes["items"] as $comprobante)
				{
					foreach($comprobante as $key => $value)
					{
						$comprobante[$key] = str_replace(",", " ", $value);
						if($key == "payments_noformat")
						{
							unset($comprobante[$key]);
						}
						
						if($key == "status")
						{
							if($value == 1)
							{
								$comprobante[$key] = "Activa";
							}
							else
							{
								$comprobante[$key] = "Cancelada";
							}
						}
						if($key == "subtotal" || $key == "total" || $key == "payments" || $key == "saldo" || $key == "iva")
						{
							$comprobante[$key] = "$".number_format($value, 2, ".", "");
						}
						
					}
					//print_r($comprobante);
					$data .= implode(",", $comprobante);
					$data .= "\n";
				}
				
				$data = utf8_decode($data);
				$data = html_entity_decode($data);
				//echo $data;
				//$data = urldecode($data);
				$myFile = DOC_ROOT."/empresas/".$_SESSION['empresaId']."_reporte_ventas.csv";
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $data);
				fclose($fh);
				echo "Reporte Generado. Ahora puedes descargarlo";
			break;				
				
	}//switch

?>
