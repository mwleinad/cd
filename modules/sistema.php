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
			$empresa->hasPermission($_GET['section']);
			$producto->CleanConceptos();
			$producto->CleanImpuestos();

			if(isset($_GET['id']))
			{
				$ticketChain = $_GET['id'];
				$smarty->assign("ticketChain", $ticketChain);
				$ticketId = $_GET["id"];
				$smarty->assign("ticketId", $ticketId);
				unset($_SESSION['ticketsId']);
				$venta->setVentaId($_GET['id']);
				$productos = $venta->GetProductos();
/*				echo "metodo producto<pre><h1>";
					print_r($productos);
				echo "</h1></pre>";
Andres*/
				
				$prodIds = array();
				foreach($productos as $res){
//					$productoId = $res['productoId'];
					$productoId = $res['noIdentificacion'];
//Andres	Ultimoif(!in_array($productoId, $prodIds))
					if(!in_array($noIdentificacion, $prodIds))
						$prodIds[] = $productoId;
/*						echo "<h1>ProIDs";
						print_r($prodIds);
						echo "</h1>";		Llenado del arrego ProIDs	Andres*/				
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
//Andres 			if($res['productoId'] == $productoId){														
						if($res['noIdentificacion'] == $productoId){							
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
						$ticketChain .= $resId.",";
						$smarty->assign("ticketChain", $ticketChain);
						
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
			
			break;
			
		case 'consultar-facturas':
			include_once(DOC_ROOT."/modules/sistema_consultar_facturas.php");
			break;
		case 'consultar-nominas':
			include_once(DOC_ROOT."/modules/sistema_consultar_nominas.php");
			break;
		
		case 'ver-pdf':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
//			if(in_array($id_empresa, $newDesignExclude) || $infoComp["tiposComprobanteId"] == TIPO_COMPROBANTE_NOMINA)
//			{
				$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/pdf/'.$archivo; 
//			}
//			else
//			{
//				unlink(DOC_ROOT.'/empresas/'.$id_empresa.'_pdf.pdf'); 
//				$path = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'; 
//				$archivo = 'SIGN_'.$id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.xml';
//				$saveTo = '/empresas/'.$id_empresa.'_pdf.pdf'; ;
//				$xmlTransform->Execute($path, $archivo, $saveTo);
//				$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
//				$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'_pdf.pdf'; 
//			}
			header( 'Cache-Control: no-store, no-cache, must-revalidate' ); 
			header( 'Cache-Control: post-check=0, pre-check=0', false ); 
			header( 'Pragma: no-cache' ); 			
			header('Location: '.$enlace.'?timestamp='.time());
/*			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: text/pdf"); 
			//header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
*/			
			exit;
		
			break;
		
		case 'descargar-pdf':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $comprobante->GetInfoComprobante($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
//			if(in_array($id_empresa, $newDesignExclude))
//			{
				$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/pdf/'.$archivo; 
//			}
//			else
//			{
//				@unlink(DOC_ROOT.'/empresas/'.$id_empresa.'_pdf.pdf'); 
//				$path = WEB_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'; 
//				$archivo = "SIGN_".$id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.xml';
//				$saveTo = '/empresas/'.$id_empresa.'_pdf.pdf';
//				$xmlTransform->Execute($path, $archivo, $saveTo);
//				$archivo = $id_empresa.'_'.$infoComp['serie'].'_'.$infoComp['folio'].'.pdf';
//				$enlace = WEB_ROOT.'/empresas/'.$id_empresa.'_pdf.pdf';  
//			}
			
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
			//header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			
			exit;
		
			break;
		case 'descargar-xml-compra':
			
			$id_comprobante = $_GET['item'];
						
			$infoComp = $compra->GetInfo($id_comprobante);
			$id_rfc = $sucursal->getRfcActive(); 
			$id_empresa = $_SESSION['empresaId'];
			
			$archivo = $infoComp["uuid"].'.xml';
			
			$enlace = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'.$archivo; 
			
			header ("Content-Disposition: attachment; filename=".$archivo."\n\n"); 
			header ("Content-Type: application/octet-stream"); 
			//header ("Content-Length: ".filesize($enlace)); 
			readfile($enlace); 
			
			exit;
		
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
			
			default: 
				$myRfc = $empresa->GetPublicEmpresaInfo();
				$pac->AddClient($myRfc["rfc"]);
			
	
	}//switch
	
	$empresa->Util()->DB()->setQuery("SELECT * FROM empresa WHERE empresaId = ".$_SESSION["empresaId"]." LIMIT 1");			
	$vencimiento = $empresa->Util()->DB()->GetRow();
	$vencimiento_move = $vencimiento;
	$smarty->assign("vencimiento", $vencimiento);
	
	$vencimientoTemp = $vencimiento;
	$vencimiento = strtotime($vencimiento["vencimiento"]) - (3600 * 24 * 30);
	$vencimientoImpuestos = strtotime($vencimientoTemp["venImpuestos"]) - (3600 * 24 * 30);
	$oneMonth = time();

	if($vencimientoImpuestos < $oneMonth)
	{
		$smarty->assign("renewImpuestos", 1);
	}	
	if($vencimientoImpuestos < $now)
	{
		$smarty->assign("expiredImpuestos", 1);
	}
	
	
	if($vencimiento < $oneMonth)
	{
		$empresa->Util()->setError(20022, "complete");
		$empresa->Util()->PrintErrors();
		
		$smarty->assign("renew", 1);
	}	

	$vencimiento = strtotime($vencimiento_move["vencimiento"]);
	$now = time() - (3600 * 24 * 7);
	
	if($vencimiento < $now && $_GET["section"] != "consultar-facturas")
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
	
	//total costo
	if($info["costo"] == 0)
	{
		$info["costo"] = COSTO_SISTEMA;
	}
	
	if($info["costoModuloNomina"] == 0)
	{
		$info["costoModuloNomina"] = COSTO_NOMINA;
	}

	if($info["costoModuloImpuestos"] == 0)
	{
		$info["costoModuloImpuestos"] = COSTO_IMPUESTOS;
	}
	
	$subtotalSistema = $info["costo"];
	
	if($info["moduloImpuestos"] == "Si")
	{
		$subtotal += $info["costoModuloImpuestos"];
	}

	if($info["moduloNomina"] == "Si")
	{
		$subtotalSistema += $info["costoModuloNomina"];
	}
	
	$ivaSistema = $subtotalSistema * IVA;
	$totalSistema = $subtotalSistema + $ivaSistema;
	$smarty->assign('subtotalSistema', $subtotalSistema);	
	$smarty->assign('ivaSistema', $ivaSistema);	
	$smarty->assign('totalSistema', $totalSistema);	
	
?>