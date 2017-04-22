<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

switch($_POST["type"])
{
	case "generaComprobante":
		/*metodopago=no identificado
		nocuenta vacio
		tipocambio 1.00*/
		
		$ticketTc = trim($_POST['ticketTC']);
		
		$datosTicket = explode(".",$ticketTc);
		// $info['notaVentaId'].".".$info['usuarioId'].".".$info['fecha'].".".$info['sucursalId'];
		
		$producto->CleanConceptos();
		$producto->CleanImpuestos();

		$venta->setVentaId(trim($datosTicket[0]));
		$venta->setUsuarioId($datosTicket[1]);
		$venta->setFecha($datosTicket[2]);
		$venta->setSucursalId($datosTicket[3]);
		
		$sucursal->setSucursalId($datosTicket[3]);
		$tiposComprobanteId = $sucursal->GetSerie();
		
		//checar tiempo para facturar
		if(!$venta->TiempoFacturar())
		{
			echo "ok[#]El tiempo para facturar este comprobante ha expirado, favor de contactar al emisor de su factura.";
			exit();
		}
		
		if($venta->notaVentaExist())
		{
			
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
			
			$cliente->setUserId($_SESSION['userId']);
			$infoCliente = $cliente->InfoCliente();
			$datosFacturacion = "";
			foreach($infoCliente as $key => $resCliente)
			{
				if($key == "nombre")
					$datosFacturacion .= "razonSocial=".$resCliente."&";
				else
					$datosFacturacion .= $key."=".$resCliente."&";
			}
			
			$datosFacturacion = trim($datosFacturacion,"&");
			
			$data['datosFacturacion'] = $datosFacturacion;
			$data['formaDePago'] = "Pago%20en%20Una%20Sola%20Exhibicion";
			$data['condicionesDePago'] = "";
			$data['metodoDePago'] = "No identificado";
			$data['NumCtaPago'] = "";
			$data['tasaIva'] = 16;
			$data['tiposDeMoneda'] = "MXN";
			$data['porcentajeRetIva'] = 0 ;
			$data['porcentajeIEPS'] = 0;
			$data['porcentajeDescuento'] = 0;
			$data['tipoDeCambio'] = 1.000;
			$data['porcentajeRetIsr'] = 0;
			
			$data['tiposComprobanteId'] = $tiposComprobanteId;
			$data['sucursalId'] = $datosTicket[3];
	
			$data["observaciones"] = $_POST["observaciones"];
	
			$data["reviso"] = $_POST["reviso"];
			$data["autorizo"] = $_POST["autorizo"];
			$data["recibio"] = $_POST["recibio"];
			$data["vobo"] = $_POST["vobo"];
			$data["pago"] = $_POST["pago"];
			$data["tiempoLimite"] = $_POST["tiempoLimite"];
			
			$data["spf"] = $_POST["spf"];
			$data["isn"] = $_POST["isn"];
			
			if($_POST["fechaSobreDia"] && $_POST["fechaSobreMes"] && $_POST["fechaSobreAnio"])
			{
				$data["fechaSobre"] = $_POST["fechaSobreDia"]."-".$_POST["fechaSobreMes"]."-".$_POST["fechaSobreAnio"];
			}
			else
			{
				$data["fechaSobre"] = "";
			}
			
			$data["folioSobre"] = $_POST["folioSobre"];
			$data["notaVentaId"] = $datosTicket[0];
			
			if(!$comprobanteCliente->Generar($data,false,$datosTicket[1]))
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
			}
			else
			{
				echo "ok[#]";
				$info = $user->Info($datosTicket[1]);
				$smarty->assign("info", $info);
				$comprobante = $comprobante->GetLastComprobante();
				$smarty->assign("comprobante", $comprobante);
				$smarty->display(DOC_ROOT.'/templates/boxes/export-factura.tpl');
			}
		}
		else
		{
			if($venta->notaVentaFacturada())
			{
				echo "fail[#]El ticket ya fue facturado.";
			}else
			{
				echo "fail[#]No se encontro ningun ticket para facturar. Revise sus datos.";
			}
		}
		
	break;
}

?>
