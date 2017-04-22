<?php

    $empresa->AuthUser();
	
	if(isset($_GET['ventaId'])){
		$ventaId = intval($_GET['ventaId']);
	}
	
	$rfc->setRfcId(1);
	$infE = $util->EncodeRow($rfc->InfoRfc());
	
	$venta->setVentaId($ventaId);
	$info = $venta->Info();
	$sucursalId = $info['sucursalId'];
	
	$codigoFacturacion = $info['notaVentaId'].".".$info['usuarioId'].".".$info['fecha'].".".$info['sucursalId'];
	
	$codigoFacturacion = str_replace(array("-"," ",":"),"",$codigoFacturacion);
	
	$info['hora'] = date('H:i:s',strtotime($info['fecha']));
	$info['fecha'] = date('d-m-Y',strtotime($info['fecha']));	
	
	/*$usuario->setUsuarioId($info['vendedorId']);
	$info['vendedor'] = strtoupper($usuario->GetFullNameById());
	
	$usuario->setUsuarioId($info['usuarioId']);
	$info['usuario'] = strtoupper($usuario->GetFullNameById());*/
	
	$sucursal->setSucursalId($info['sucursalId']);
	$infS = $sucursal->Info();
	$infS['nombre'] = strtoupper($infS['nombre']);
	$infS = $util->DecodeUrlRow($infS);
	$infS = $util->DecodeRow($infS);
	
	//Obtenemos los Productos
	
	$venta->setVentaId($ventaId);
	$resProds = $venta->GetProductos();
	$productos = array();//array Vacio
	foreach($resProds as $res)
	{

		/*** OBTENEMOS TOTALES ***/
		
		$total = $res['valorUnitario'];
		$valDesc = $res['valDesc'];
		if($res['tipoDesc'] == 'Dinero')			
			$total -= $valDesc * $res['cantidad'];						
		elseif($res['tipoDesc'] == 'Porcentaje')			
			$total -= $total * ($valDesc / 100);		
		
		$total = number_format($total,2,'.','');
				
		$res['totalDesc'] = $total;
		$productos[] = $res;
	}//foreach
	
	$cambio = 0;
	if($info['pago'] > $info['total'])
		$cambio = $info['pago'] - $info['total'];
	
	$info['cambio'] = $cambio;
	
	//Agrupamos los Productos solo para Vista
				
	$prodIds = array();
foreach($productos as $res){
		
		$productoId = $res['conceptoId'];		
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
			if($res['conceptoId'] == $productoId){							
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
		
		if($card['promocionId']){
			$promocion->setPromocionId($card['promocionId']);
			$nomPromo = $promocion->GetNameById();
			$card['nombre'] .= '<br>Promoci&oacute;n: '.$nomPromo;
		}
		
		$products[] = $card;
				
	}//foreach
	
	if($sucursalId == 1)
		$fontSize = 11;
	else
		$fontSize = 12;
		
	$smarty->assign('infE', $infE);
	$smarty->assign('infS', $infS);
	$smarty->assign('info', $info);	
	$smarty->assign('mode', $mode);	
	$smarty->assign('fontSize', $fontSize);	
	$smarty->assign('productos', $products);
	$smarty->assign('codigoFacturacion',$codigoFacturacion);
	$smarty->display(DOC_ROOT."/templates/ventas-ticket.tpl");
	
	exit;
				
?>