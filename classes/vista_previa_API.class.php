<?php

class VistaPrevia extends Comprobante
{
	function VistaPreviaComprobante($data, $notaCredito = false)
	{	
		//Checamos si existe el ID de la Empresa
		
		$sql = 'SELECT * FROM empresa 
				WHERE empresaId = "'.$_SESSION['empresaId'].'"';
		$this->Util()->DB()->setQuery($sql);
		$empresa = $this->Util()->DB()->GetRow();

		if(!$empresa['empresaId']){
			$msgRet['error'] = 'El ID de la empresa no existe.';
			return $msgRet;
		}
		
		$vs = new User;
		$activeRfc =  $vs->getRfcActive();
		
		//Checamos si existe el RFC del Cliente
		
		$sql = 'SELECT userId FROM cliente 
				WHERE rfc = "'.$data['rfcReceptor'].'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['userId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		if(!$data['userId']){
			$msgRet['error'] = 'El RFC del cliente no existe.';
			return $msgRet;
		}
		
		//Checamos si existe el Tipo de Comprobante
		
		$sql = 'SELECT tiposComprobanteId FROM tiposComprobante 
				WHERE UPPER(nombre) = "'.strtoupper($data['tipoComprobante']).'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['tiposComprobanteId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		if(!$data['tiposComprobanteId']){
			$msgRet['error'] = 'El tipo de comprobante no existe.';
			return $msgRet;
		}
		
		//Checamos si existe la Sucursal
		
		$sql = 'SELECT sucursalId FROM sucursal 
				WHERE UPPER(identificador) = "'.strtoupper($data['sucursal']).'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['sucursalId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if(!$data['sucursalId']){
			$msgRet['error'] = 'La sucursal no existe.';
			return $msgRet;
		}
				
		//Checamos si existe la Serie
		
		if($notaCredito){
			$sql = 'SELECT serieId FROM serie 
					WHERE tiposComprobanteId = "2" 
					AND empresaId = '.$_SESSION["empresaId"].' 
					AND rfcId = "'.$activeRfc.'" 
					AND consecutivo <= folioFinal 
					AND UPPER(serie) = "'.strtoupper($data["serie"]).'" 
					ORDER BY serieId DESC LIMIT 1';
		}else{
			$sql = 'SELECT serieId FROM serie 
					WHERE UPPER(serie) = "'.strtoupper($data['serie']).'"
					AND sucursalId = "'.$data['sucursalId'].'"
					AND tiposComprobanteId = "'.$data['tiposComprobanteId'].'"
					AND empresaId = '.$_SESSION["empresaId"].'
					AND rfcId = "'.$activeRfc.'"
					AND consecutivo <= folioFinal
					ORDER BY serieId DESC LIMIT 1';
		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['serieId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if(!$data['serieId']){
			$msgRet['error'] = 'La serie no existe.';
			return $msgRet;
		}
		
		$data["tiposSerieId"] = $data['serieId'];
		
		//Checamos la Forma de Pago
		
		if(strlen($data["formaDePago"]) <= 0){
			$msgRet['error'] = 'La forma de pago no esta definida.';
			return $msgRet;
		}
		
		$myData = urlencode(serialize($data));
				
		$values = explode("&", $data["datosFacturacion"]);
		unset($data["datosFacturacion"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		if(count($_SESSION["conceptos"]) < 1)
		{
			$msgRet['error'] = 'No existen conceptos para facturar.';
			return $msgRet;
		}
		
		/*		
		if(!is_numeric($data["numDiasPagados"]) && $data["fromNomina"])
		{
			echo "El numero de dias pagados debe de ser un numero";
		}
		*/
						
		$myConceptos = urlencode(serialize($_SESSION["conceptos"]));
		$myImpuestos = urlencode(serialize($_SESSION["impuestos"]));
		
		$userId = $data["userId"];
		
		$totales = $this->GetTotalDesglosado($data);

		if($vs->Util()->PrintErrors()){ return false; }
		
		if(!$data["tipoDeCambio"])
		{
			$data["tipoDeCambio"] = "1.00";
		}

		if(!$data["porcentajeDescuento"])
		{
			$data["porcentajeDescuento"] = "0";
		}

		if(!$data["porcentajeIEPS"])
		{
			$data["porcentajeIEPS"] = "0";
		}
				
		//Get datos serie de acuerdo al tipo de comprobabte expedido.
		
		if(!$data["metodoDePago"])
		{
			$msgRet['error'] = 'El metodo de pago no puede ser vacio.';
			return $msgRet;
		}

		if($data["NumCtaPago"])
		{
			if(strlen($data["NumCtaPago"]) < 4)
			{
				$msgRet['error'] = 'El numero de cuenta debe de tener 4 digitos';
				return $msgRet;
			}
		}
						
		$sql = 'SELECT * FROM serie 
				WHERE serieId = "'.$data['serieId'].'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$serie = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$folio = $serie["consecutivo"];
		$fecha = $this->Util()->FormatDateAndTime(time());
		
		//El tipo de comprobante lo determina tiposComprobanteId
		
		$tipoDeComprobante = $this->GetTipoComprobante($data["tiposComprobanteId"]);
		$data["comprobante"] = $this->InfoComprobante($data["tiposComprobanteId"]);
		
		$data["serie"] = $serie;
		$data["folio"] = $folio;
		$data["fecha"] = $fecha;
		$data["tipoDeComprobante"] = $tipoDeComprobante;
		$data["certificado"] = $serie["noCertificado"];

		//Build informacion Nodo Emisor
		
		$myEmpresa = new Empresa;
		$myEmpresa->setEmpresaId($_SESSION["empresaId"], 1);
		$myEmpresa->setSucursalId($data["sucursalId"]);
		$nodoEmisor = $myEmpresa->GetSucursalInfo();

		$this->setRfcId($activeRfc);
		$nodoEmisorRfc = $this->InfoRfc();

		$data["nodoEmisor"]["sucursal"] = $nodoEmisor;
		$data["nodoEmisor"]["rfc"] = $nodoEmisorRfc;
		
		if(!$data["nodoEmisor"]["rfc"]["regimenFiscal"])
		{
			$msgRet['error'] = 'Regimen fiscal no definido.';
			return $msgRet;
		}
		
		if($_SESSION["version"] == "auto")
		{
			$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/qrs/";
			$qrRfc = strtoupper($nodoEmisorRfc["rfc"]);
			$nufa = $serie["serieId"]."_".$serie["noAprobacion"]."_".$qrRfc.".png";
			//echo $rootQr.$nufa;
			if(!file_exists($rootQr.$nufa))
			{
				$nufa = $serie["serieId"]."_".$serie["noAprobacion"]."_".$qrRfc."_.png";
				if(!file_exists($rootQr.$nufa))
				{
					$nufa = $serie["serieId"].".png";
					if(!file_exists($rootQr.$nufa))
					{
						echo 10048;
					}
				}
			}			
		}
				
		$userId = $data["userId"];
																		 
		//Build Nodo Receptor
		
		if(!$data["fromNomina"])
		{			
			$sql = "SELECT * FROM cliente WHERE userId = ".$userId;
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$nodoReceptor = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		}
		else
		{
			$usuario = new Usuario;
			$usuario->setUsuarioId($userId);
			$nodoReceptor = $usuario->InfoUsuario();
		}
		$data["nodoReceptor"] = $nodoReceptor;
		
		//Checar si nos falta unidad en alguno
		
		foreach($_SESSION["conceptos"] as $concepto)
		{
			if($concepto["unidad"] == "")
			{
				$msgRet['error'] = 'Falta definir la unidad en uno de los conceptos.';
				return $msgRet;
			}
		}
		
		//check tipo de cambio
		switch($_SESSION["version"])
		{
			case "auto":
			case "v3":
			case "construc":
				include_once(DOC_ROOT.'/classes/cadena_original_v3.class.php');break;
			case "2": 
			default:	
				include_once(DOC_ROOT.'/classes/cadena_original_v2.class.php');break;
		}
		$cadena = new Cadena;				
		$cadenaOriginal = $cadena->BuildCadenaOriginal($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"]);

		$data["cadenaOriginal"] = utf8_encode($cadenaOriginal);
		$data["cadenaOriginal"] = $cadenaOriginal;
		
		$md5Cadena = utf8_decode($cadenaOriginal);

		$md5 = sha1($md5Cadena);
		
		//GeneratePDF
		
		define('SITENAME','FACTURASE');
		$_SESSION["version"] = 2;
		
		if(!$data["fromNomina"])
		{
			switch(SITENAME)
			{
				case "FACTURASE": include_once(DOC_ROOT."/classes/disenios_facturase_previa.php"); break;
				default: include_once(DOC_ROOT."/classes/disenios_confactura_previa.php"); break;
			}
		}
		else
		{
				include_once(DOC_ROOT."/classes/override_generate_pdf_nomina.php");
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");
		}
		
		$msgRet['ok'] = 'OK';
		
		return $msgRet;
		
	}//VistaPreviaComprobante
	
}



?>