<?php
	$cliente->AuthUser();

	switch($_GET["section"]){
	
		case "nueva-factura":
			$empresa->hasPermission($_GET['section']);
			$producto->CleanConceptos();
			$producto->CleanImpuestos();
			
			if(isset($_GET['id']))
			{
				unset($_SESSION['ticketsId']);
				$venta->setVentaId($_GET['id']);
				$productos = $venta->GetProductos();
				
				$prodIds = array();
				foreach($productos as $res){
					
					$productoId = $res['productoId'];
					
					if(!in_array($productoId, $prodIds))
						$prodIds[] = $productoId;
					
				}//foreach
				
				$products = array();
				foreach($prodIds as $productoId){					
					
					$promocionId = 0;
					$total2 = 0;
					$precio = 0;
					$cantidad = 0;
					$totalDesc = 0;
					$card = array();					
					foreach($productos as $res){
												
						if($res['productoId'] == $productoId){							
							$card = $res;
							
							if($res['promocionId'])
								$promocionId = $res['promocionId'];
							
							if($res['valorUnitario'] > $precio)
								$precio = $res['valorUnitario'];
							
							$cantidad += $res['cantidad'];
							$totalDesc += $res['totalDesc'];
							
							$total2 += $res['importe'];
						}
						
					}//foreach
					
					$card['precioUnitario'] = $precio;
					$card['cantidad'] = $cantidad;
					$card['total'] = $total2;
					$card['totalDesc'] = $totalDesc;
					$card['promocionId'] = $promocionId;
					
					$products[] = $card;
							
				}//foreach
				foreach($products as $key => $resProducto)
				{
					$producto->setCantidad($resProducto["cantidad"]);
					$producto->setNoIdentificacion($resProducto["noIdentificacion"]);
					$producto->setUnidad($resProducto["unidad"]);
					$producto->setDescripcion($resProducto["descripcion"]);
					$producto->setValorUnitario($resProducto["valorUnitario"]);
					$producto->setExcentoIva($resProducto["excentoIva"]);
					$producto->setCategoriaConcepto($resProducto["categoriaConcepto"]);
					$producto->setImporte();
					$producto->AgregarConcepto();
				}
				$totalDesglosado = $producto->GetTotalDesglosado2(16);
				$smarty->assign("impuestos", $totalDesglosado["impuestos"]);
				unset($totalDesglosado["impuestos"]);		
				if($totalDesglosado){
					foreach($totalDesglosado as $key => $total)
					{
						$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
					}
				}
				
				$smarty->assign("totalDesglosado", $totalDesglosado);
				$smarty->assign("conceptos", $_SESSION["conceptos"]);
				$smarty->assign("notaVentaId", $_GET["id"]);
			}else
			{
				if(isset($_SESSION['ticketsId']))
				{
					$producto->CleanConceptos();
					$producto->CleanImpuestos();
					
					$subtotal = $iva = $total = 0;
					$concepto = "Factura con base a los tickets: ";
					$products = array();
					foreach($_SESSION['ticketsId'] as $key => $resId)
					{
						$venta->setVentaId($resId);
						$infoVenta = $venta->Info();
						$subtotal += $infoVenta['subtotal'];
						$iva += $infoVenta['iva'];
						$total += $infoVenta['total'];
						$concepto .= $resId.",";
					}
					$concepto = trim($concepto, ",");
					$producto->setCantidad(1);
					$producto->setNoIdentificacion(" ");
					$producto->setUnidad("Pieza");
					$producto->setDescripcion($concepto);
					$producto->setValorUnitario($subtotal);
					$producto->setExcentoIva("no");
					$producto->setCategoriaConcepto("");
					$producto->setImporte();
					$producto->AgregarConcepto();
					
					$totalDesglosado = $producto->GetTotalDesglosado2(16);
					$smarty->assign("impuestos", $totalDesglosado["impuestos"]);
					unset($totalDesglosado["impuestos"]);		
					if($totalDesglosado){
						foreach($totalDesglosado as $key => $total)
						{
							$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
						}
					}
					
					$smarty->assign("totalDesglosado", $totalDesglosado);
					$smarty->assign("conceptos", $_SESSION["conceptos"]);
				}
			}
			$ivas = $main->ListIvas();
			$smarty->assign("ivas", $ivas);
			$retIsrs = $main->ListRetIsr();
			$smarty->assign("retIsrs", $retIsrs);
			$retIvas = $main->ListRetIva();
			$smarty->assign("retIvas", $retIvas);
			$tiposDeMoneda = $main->ListTipoDeMoneda();
			$smarty->assign("tiposDeMoneda", $tiposDeMoneda);
			$comprobantes = $main->ListTiposDeComprobantesValidosBySucursal();
			$smarty->assign("comprobantes", $comprobantes);		
			$sucursal->setRfcId($rfc->getRfcActive());
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$resSucursales = $sucursal->GetSucursalesByRfc();
			$resSuc = $util->DecodeUrlResult($resSucursales);
			$sucursales = $util->DecodeResult($resSuc);
			$smarty->assign("sucursales", $sucursales);		
			$excentoIva = $main->ListExcentoIva();
			$smarty->assign("excentoIva", $excentoIva);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			
			break;
			
		case 'consultar-facturas':
			$empresa->hasPermission($_GET['section']);
			$comprobantes = array();
			$comprobante->SetPage($_GET["p"]);
			$result = $comprobante->GetComprobantesByRfc();

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
		
			break;
		
		case 'ver-pdf':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
			
			$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/pdf/'.$archivo; 
			/*
			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: application/octet-stream"); 
			header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			*/
			header('Location: '.$enlace);
			exit;
		
			break;
		
		case 'descargar-pdf':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
			
			$enlace = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/pdf/'.$archivo; 

			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: text/pdf"); 
			//header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			
			exit;
		
			break;
		
		case 'descargar-xml':
			
			$id_comprobante = $_GET['item'];
	
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			
			if($_SESSION["version"] == "v3" || $_SESSION["version"] == "construc")
			{
				$archivo = "SIGN_".$id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.xml';
			}
			else
			{
				$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.xml';
			}
			$enlace = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'.$archivo; 
			
			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: application/octet-stream"); 
			header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			exit();
		
			break;
		
		case 'enviar-pdf':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.xml';
			
			$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'.$archivo; 
			
			$comprobante->Util()->setError(20011, 'complete');		
			$comprobante->Util()->PrintErrors();
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');			
							
			break;
		
		case 'demo-pdf':
			
			$card["nombre"] = "Asociacion Mexicana de Contadores Publicos, Colegio Profesional en el Estado de Chiapas AC";
			$card["calle"] = "Avenida de los Treboles";
			$card["noExt"] = "123";
			$card["noInt"] = "234-A";
			$card["colonia"] = "Jardines de Tuxtla";
			$card["municipio"] = "Tuxtla Gutierrez";
			$card["estado"] = "Quintana Roo";
			$card["pais"] = "Mexico";
			$card["cp"] = "29060";
			$card["rfc"] = "RFC123456789";
			
			$data["nodoReceptor"] = $card;
						
			$comprobante->GenerateDemoPDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, 0);
			
			$archivo = 'DemoPDF.pdf';
			
			$enlace = WEB_ROOT.'/empresas/'.$archivo; 
			
			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: application/octet-stream"); 
			header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			
			
			exit;
			
			break;
	
	}//switch
	
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