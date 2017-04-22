<?php

	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

	switch($_POST['type']){
		case 'listPaymentsPdf':
			include(DOC_ROOT.'/pdf/payments.php');
		break;
		case 'deletePayment':
			$paymentCompra->setPaymentId($_POST["id"]);
			$paymentInfo = $paymentCompra->Info();
			$paymentCompra->DeletePayment();
			echo "ok[#]";
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			echo "[#]";
			$paymentCompra->setComprobanteId($paymentInfo["compraId"]);
			$payments = $paymentCompra->Enumerate();
			$smarty->assign("payments", $payments);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/lists/paymentsCompra.tpl');
			break;
		case 'saveAddPayment':
			$paymentCompra->setComprobanteId($_POST["comprobanteId"]);
			$paymentCompra->setAmount($_POST["importe"]);

			if(!$paymentCompra->AddPayment())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$payments = $paymentCompra->Enumerate($_POST["comprobanteId"]);
				$smarty->assign("payments", $payments);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/paymentsCompra.tpl');
			}
			break;
		case 'addPayment':
		
			$id_comprobante = $_POST['id'];			
			$infoComprobante =  $compra->GetInfo($id_comprobante);
			$paymentCompra->setComprobanteId($id_comprobante);
			$payments = $paymentCompra->Enumerate($id_comprobante);
			
			$smarty->assign('payments', $payments);
			$smarty->assign('infoComprobante', $infoComprobante);
			$smarty->assign('DOC_ROOT', DOC_ROOT);		
			
			$smarty->display(DOC_ROOT.'/templates/boxes/add-paymentCompra-popup.tpl');
			
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
		
		case 'showDetailsCliente':
		
			$id_comprobante = $_POST['id_item'];			
			
			$compInfo = $comprobante->GetInfoComprobante($id_comprobante);
			$user->setUserId2($_SESSION['userId'],1);
			$usr = $user->GetUserInfo();
			$nomRfc = $usr['rfc'];
			
			$serie = $compInfo['serie'];
			$folio = $compInfo['folio'];
			
			$smarty->assign('id_comprobante', $id_comprobante);
			$smarty->assign('rfc', $nomRfc);
			$smarty->assign('serie', $serie);
			$smarty->assign('folio', $folio);
			$info["version"] = $_SESSION["version"];
			$smarty->assign('info', $info);
			$smarty->assign('DOC_ROOT', DOC_ROOT);		
			//$info = $user->Info();
			
			//$smarty->assign("info", $info);	
			$smarty->display(DOC_ROOT.'/templates/boxes/cliente-acciones-factura-popup.tpl');
			
			break;
		
		case 'cancelar_div':
		
			$id_comprobante = $_POST['id_item'];			
			
			$compInfo = $comprobante->GetInfoComprobante($id_comprobante);
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
			$smarty->assign('DOC_ROOT', DOC_ROOT);			
			$smarty->display(DOC_ROOT.'/templates/boxes/cancelar-factura-popup.tpl');
			
			break;
		
		case 'cancelar_factura':
		
			$empresa->setComprobanteId($_POST['id_comprobante']);
			$empresa->setMotivoCancelacion($_POST['motivo']);
															
			if(!$empresa->CancelarComprobante()){
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{
				
				$comprobantes = $comprobante->GetComprobantesByRfc();
	
				if(count($comprobantes['items']) > 0)
					$comprobantes["items"] = $util->DecodeResult($comprobantes["items"]);	
								
				$total = 0;
				$subtotal = 0;
				$iva = 0;
				$isr = 0;
				
				if(count($comprobantes["items"]) > 0){
				
					foreach($comprobantes["items"] as $res){
						if($res["status"] == 0)
							continue;
						
						if($res["tipoDeComprobante"] == "ingreso"){
							$total += $res['total'];
							$subtotal += $res['subTotal'];
							$iva += $res['ivaTotal'];
							$isr += $res['isrRet'];
							$payments += $res['payments_noformat'];
						}else{
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
				$smarty->assign('DOC_ROOT', DOC_ROOT);
				
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');				
				echo '[#]';				
				$smarty->display(DOC_ROOT.'/templates/boxes/resumen-facturas.tpl');
				echo '[#]';				
				$smarty->display(DOC_ROOT.'/templates/lists/facturas.tpl');
				
				
			}//else
			break;			
		
		case 'buscar':
				
				foreach($_POST as $key => $val){
					$values[$key] = $val;
				}
				
				$comprobantes = array();
				$comprobantes = $compra->Search($values);				
				$smarty->assign('comprobantes',$comprobantes);
								
				$total = 0;
				$subtotal = 0;
				$iva = 0;
				$isr = 0;
				
				if(count($comprobantes["items"]) > 0){
					foreach($comprobantes["items"] as $res){
							echo $total += $res['total'];
							$subtotal += $res['subTotal'];
							$iva += $res['ivaTotal'];
							$isr += $res['isrRet'];
							$payments += $res['payments_noformat'];
					}
				}
	
				$debt = number_format($total-$payments,2,'.',',');
				$payments = number_format($payments,2,'.',',');
				$total = number_format($total,2,'.',',');
				$subtotal = number_format($subtotal,2,'.',',');
				$iva = number_format($iva,2,'.',',');
				$isr = number_format($isr,2,'.',',');
	
				$smarty->assign('total',$total);
				$smarty->assign('subtotal',$subtotal);
				$smarty->assign('iva',$iva);
				$smarty->assign('isr',$isr);
				$smarty->assign('payments',$payments);
				$smarty->assign('debt',$debt);
							
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/resumen-compras.tpl');
				echo '[#]';
								
				$smarty->assign('DOC_ROOT', DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/compras.tpl');
				
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
				$comprobantes = $compra->Search($values);		
				
				
				$data .= "Serie,Folio,RFC,Razon Social,Fecha,Subtotal,% Descuento,Descuento,Iva,Total,% Retencion Iva,% Retencion ISR,% IEPS, XML, Pagos, Estatus Pago \n";

					foreach($comprobantes["items"] as $comprobante)
					{
						foreach($comprobante as $key => $value)
						{
							$comprobante[$key] = str_replace(",", " ", $value);
							
							if($key == "total" || $key == "comprobanteId" || $key == "payments_noformat")
							{
								unset($comprobante[$key]);
							}
							
							if($key == "subTotal" || $key == "ivaTotal" || $key == "total_formato" || $key == "tipoDeCambio")
							{
								$comprobante[$key] = "$".number_format($value, 2, ".", "");
							}
							
							if($key == "porcentajeRetIva" || $key == "porcentajeRetIsr" || $key == "porcentajeIEPS" || $key == "porcentajeDescuento")
							{
								$comprobante[$key] = number_format($value, 2, ".", "")."%";
							}
						}
	
						$data .= implode(",", $comprobante);
						$data .= "\n";
					}
				$data = utf8_decode($data);
				$data = html_entity_decode($data);

				$myFile = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."_reporte_compras.csv";
				$fh = fopen($myFile, 'w') or die("can't open file");
				fwrite($fh, $data);
				fclose($fh);
				
				echo 'ok[#]';
				echo "Reporte Generado. Ahora puedes descargarlo";
				
			break;			
			
		case 'descargar':
				foreach($_POST as $key => $val){
					$values[$key] = $val;
				}
				
				$comprobantes = array();
				$comprobantes = $compra->Search($values);		
				
				
				$returnPath = WEB_ROOT."/empresas/".$_SESSION["empresaId"]."_zippedFile.zip";
				$path = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."_zippedFile.zip";
				$rfcActivo = $rfc->getRfcActive();
				@unlink($path);
				$zip = new ZipArchive();
				$res = $zip->open($path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
				foreach($comprobantes["items"] as $comprobante)
				{
					$xml = $comprobante["xml"];

					$file = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/".$xml.".xml";		

					$fileName = $xml.".xml";
					
					$zip->addFile($file,$fileName);
					
				}
				
	    	$zip->close();

				echo 'ok[#]';
				echo $returnPath;
				
			break;							
				
	}//switch

?>
