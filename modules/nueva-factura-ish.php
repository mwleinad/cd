<?php
	$_GET["section"] = "nueva_factura";
	$empresa->AuthUser();
	
	$info = $empresa->Info();
	$smarty->assign("info", $info);

	$empresa->Util()->DB()->setQuery("SELECT * FROM usuario");
	$result = $empresa->Util()->DB->GetResult();

	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());

			$empresa->hasPermission($_GET['section']);
			$producto->CleanConceptos();
			$producto->CleanImpuestos();
			
			if(isset($_GET['id']))
			{
				$ticketChain = $_GET["id"];
				$smarty->assign("ticketChain", $ticketChain);

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
	
	$subtotal = $info["costo"];
	
	if($info["moduloImpuestos"] == "Si")
	{
		$subtotal += $info["costoModuloImpuestos"];
	}

	if($info["moduloNomina"] == "Si")
	{
		$subtotal += $info["costoModuloNomina"];
	}
	
	$iva = $subtotal * IVA;
	$total = $subtotal + $iva;
	$smarty->assign('subtotal', $subtotal);	
	$smarty->assign('iva', $iva);	
	$smarty->assign('total', $total);	
?>