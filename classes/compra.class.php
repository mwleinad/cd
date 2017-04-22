<?php
class Compra extends Producto{

	function Search($values){
	
		global $user;
		
		$sqlSearch = '';
		
		if($values['rfc']){
			$sqlSearch .= ' AND compra.rfc LIKE "%'.$values['rfc'].'%"';
		}//if
		
		if($values['nombre']){
			$sqlSearch .= ' AND proveedor.razonSocial LIKE "%'.$values['nombre'].'%"';
		}//if
				
		if($values['mes']){
			$sqlSearch .= ' AND EXTRACT(MONTH FROM compra.fecha) = '.$values['mes'];
		}//if
		
		if($values['anio'])
			$sqlSearch .= ' AND EXTRACT(YEAR FROM compra.fecha) = '.intval($values['anio']);		
		
		if($values['status_activo'] != '')		
			$sqlSearch .= ' AND compra.status = "'.$values['status_activo'].'"';
		
		$id_rfc = $this->getRfcActive();
				
		 $sqlQuery = 'SELECT 
					compra.*, proveedor.*
					FROM 
						compra
					LEFT JOIN proveedor ON proveedor.rfc = compra.rfc 
					WHERE 1 
							'.$sqlSearch.'							 
					ORDER BY 
							compra.fecha DESC';
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			$user->setUserId($val['userId'],1);
			
			$errores = $user->Util()->getErrors();
			$user->Util()->cleanErrors();
			
			$card = array();
			$card['serie'] = $val['serie'];
			$card['folio'] = $val['folio'];
			$card['rfc'] = $val['rfc'];
			$card['nombre'] = $val['razonSocial'];
			$card['fecha'] = date('d/m/Y',strtotime($val['fecha']));
			$card['subTotal'] = $val['subtotal'];
			$card['porcentajeDescuento'] = $val['porcentajeDescuento'];
			$card['descuento'] = $val['descuento'];
			$card['ivaTotal'] = $val['iva'];
			$card['total'] = $val['total'];
			$card['total_formato'] = $val['total'];
			$card['porcentajeRetIva'] = $val['porcentajeRetIva'];
			$card['porcentajeRetIsr'] = $val['porcentajeRetIsr'];
			$card['porcentajeIEPS'] = $val['porcentajeIEPS'];
			$card['comprobanteId'] = $val['compraId'];
//			$card['status'] = $val['status'];
//			$card['tipoDeComprobante'] = $val['tipoDeComprobante'];
			$card['xml'] = $val['uuid'];
			$card['comprobanteId'] = $val['compraId'];


			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM paymentCompra WHERE compraId = '".$val['compraId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');
			
			$card["statusPayment"] = "Debe";
			if($card["payments_noformat"] >= ($card['total'] - 0.01))
			{
				$card["statusPayment"] = "Pagada";
			}
			
			//checar filtro
			if($values['status'] == "Pagadas")
			{
				if($card["statusPayment"] == "Debe")
				{
					continue;
				}
			}

			if($values['status'] == "No Pagadas")
			{
				if($card["statusPayment"] == "Pagada")
				{
					continue;
				}
			}

			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//SearchComprobantesByRfc
	
	
	function GetInfo($id_comprobante){
	
		$sqlQuery = 'SELECT * FROM compra WHERE compraId = '.$id_comprobante;	
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sqlQuery);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$card['total_formato'] = number_format($row['total'],2,'.',',');
			
		//get payments
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM paymentCompra WHERE compraId = '".$id_comprobante."'");

		$row["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		$row["payments"] = number_format($row["payments_noformat"],2,'.',',');
			
		$row["statusPayment"] = "Debe";
		if($row["payments_noformat"] >= $row['total'])
		{
			$row["statusPayment"] = "Pagada";
		}
		
		$row["debt"] = number_format($row["total"] - $row["payments_noformat"],2,'.',',');
		$row["debt_noformat"] = $row["total"] - $row["payments_noformat"];
		
		return $row;
	
	}//GetInfoComprobante
	
	function GetCompras(){
	
		global $user;
				
		$id_rfc = $this->getRfcActive();

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM compra ORDER BY fecha DESC');
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/sistema/consultar-facturas");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$sqlQuery = 'SELECT * FROM compra 
		LEFT JOIN proveedor ON proveedor.rfc = compra.rfc
		WHERE  1  ORDER BY fecha DESC '.$sqlAdd;
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			

			$card['rfc'] = $val['rfc'];
			$card['nombre'] = $val['razonSocial'];
			$card['fecha'] = date('d-m-Y',strtotime($val['fecha']));
			
			$card['subTotal'] = $val["subtotal"];
			$card['total'] = $val["total"];
																		 
			$card['ivaTotal'] = $val["iva"];
			$card['isrRet'] = $val["isrRet"];

			$card['total_formato'] = number_format($card['total'],2,'.',',');
			$card['serie'] = $val['serie'];
			$card['folio'] = $val['folio'];

			$card['comprobanteId'] = $val['compraId'];
			$card['status'] = $val['status'];
			$card['tipoDeComprobante'] = $val['tipoDeComprobante'];

			$card["uuid"] = $val["UUID"];
			
			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM paymentCompra WHERE compraId = '".$val['compraId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');

			$card["statusPayment"] = "Debe";
			if($card["payments_noformat"] >= ($card['total'] - 0.01))
			{
				$card["statusPayment"] = "Pagada";
			}

			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//GetComprobantesByRfc
	
	function Confirmar($data) 
	{
			//meter la compra a la base si no existe
			$sql = "SELECT COUNT(*) FROM compra WHERE uuid = '".$_POST["uuid"]."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$count = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			
			if($count > 0)
			{
				return "Ya existe una compra con ese UUID favor de utilizar otro comprobante.";
			}
			
			$empresa = new Empresa;
			$emp = $empresa->GetPublicEmpresaInfo();

			if($emp["rfc"] != $data["nodoReceptor"]["rfc"])
			{
				return "Este comprobante no pertenece a tu RFC";
			}
			
			$sql = "INSERT INTO  `compra` (
				`uuid` ,
				`subtotal` ,
				`descuento` ,
				`iva` ,
				`total` ,
				`tasaIva` ,
				`serie` ,
				`folio` ,
				`fecha` ,
				`tipoDeComprobante` ,
				`retIva` ,
				`retIsr` ,
				`ieps` ,
				`rfc`
				)
				VALUES (
				'".$data["UUID"]."',  
				'".$data["totales"]["subtotal"]."',  
				'".$data["totales"]["descuento"]."',  
				'".$data["totales"]["iva"]."',  
				'".$data["totales"]["total"]."',  
				'".$data["totales"]["tasaIva"]."',  
				'".$data["serie"]["serie"]."',  
				'".$data["folio"]."',  
				'".$data["fecha"]."',  
				'".$data["tipoDeComprobante"]."',  
				'".$data["totales"]["retIva"]."',  
				'".$data["totales"]["retIsr"]."',  
				'".$data["totales"]["ieps"]."',  
				'".$data["nodoEmisor"]["rfc"]["rfc"]."')";
//			print_r($emp);
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$id = $this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();

			foreach($data["conceptos"] as $key => $concepto)
			{
				$sql = "INSERT INTO  `conceptoCompra` (
					`compraId` ,
					`cantidad` ,
					`unidad` ,
					`noIdentificacion` ,
					`descripcion` ,
					`valorUnitario` ,
					`importe`
					)
					VALUES (
					'".$id."',
					'".$concepto["cantidad"]."',
					'".$concepto["unidad"]."',
					'".$concepto["noIdentificacion"]."',
					'".$concepto["descripcion"]."',
					'".$concepto["valorUnitario"]."',
					'".$concepto["importe"]."')";
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
				
				//checar si producto existe
				$sql = "SELECT COUNT(*) FROM producto WHERE noIdentificacion = '".$concepto["noIdentificacion"]."'";
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$countProducto = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
				
				$rfc = new Rfc;
				$rfcActivo = $rfc->getRfcActive();
				
				if(!in_array($concepto["noIdentificacion"], $_POST["concepto"]))
				{
					continue;
				}
				
					if($countProducto == 0)
					{
						$sql = "INSERT INTO  `producto` (
							`empresaId` ,
							`noIdentificacion` ,
							`unidad` ,
							`precioCompra` ,
							`descripcion` ,
							`rfcId` ,
							`descuento` ,
							`tasaIva`
							)
							VALUES (
							'".$_SESSION["empresaId"]."',  
							'".$concepto["noIdentificacion"]."',
							'".$concepto["unidad"]."',
							'".$concepto["valorUnitario"]."',
							'".$concepto["descripcion"]."',
							'".$rfcActivo."',  
							'0',  
							'16')";
						$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
						$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
						
						$sql = "UPDATE producto SET valorUnitario = '".$_POST["precioVenta"][trim($concepto["noIdentificacion"])]."' WHERE noIdentificacion = '".$concepto["noIdentificacion"]."'";
						$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
						$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
						
					}
					
					//agregar al disponible
					$sql = "UPDATE producto SET disponible = disponible + '".$concepto["cantidad"]."' WHERE noIdentificacion = '".$concepto["noIdentificacion"]."'";
					$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
					$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
			}

			$sql = "SELECT COUNT(*) FROM proveedor WHERE rfc = '".$data["nodoEmisor"]["rfc"]["rfc"]."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$countProveedor = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			
			if($countProveedor == "0")
			{
				$sql = "INSERT INTO  `proveedor` (
					`rfc` ,
					`razonSocial`
					)
					VALUES (
					'".$data["nodoEmisor"]["rfc"]["rfc"]."',
					'".$data["nodoEmisor"]["rfc"]["razonSocial"]."')";
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			}
			
			//insertar proveedor sino esta
			
			return "Se ha registrado la compra correctamente y se ha agregado el producto seleccionado a inventario";
//			print_r($_SESSION);
	}
	
}
?>
