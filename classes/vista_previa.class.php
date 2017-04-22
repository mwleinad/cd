<?php

class VistaPrevia extends Comprobante
{
	function VistaPreviaComprobante($data, $notaCredito = false)
	{
		$myData = urlencode(serialize($data));
		$empresa = $this->Info();
		$values = explode("&", $data["datosFacturacion"]);
		unset($data["datosFacturacion"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		$tipoSerie = explode("-", $data["tiposComprobanteId"]);
		$data["tiposComprobanteId"] = $tipoSerie[0];
		$data["tiposSerieId"] = $tipoSerie[1];
		$vs = new User;

		if(!is_numeric($data["numDiasPagados"]) && $data["fromNomina"])
		{
			$vs->Util()->setError(10041, "error", "El numero de dias pagados debe de ser un numero");
		}
		
		$vs->setRFC($data["rfc"]);
		$vs->setCalle($data["calle"]);
		$vs->setPais($data["pais"]);

		if(strlen($data["formaDePago"]) <= 0)
		{
			$vs->Util()->setError(10041, "error", "");
		}
		
		if(count($_SESSION["conceptos"]) < 1)
		{
			$vs->Util()->setError(10040, "error", "");
		}
		
		$myConceptos = urlencode(serialize($_SESSION["conceptos"]));
		
		$userId = $data["userId"];
		
		$totales = $this->GetTotalDesglosado($data);
		//print_r($totales);
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
		
		//get active rfc
		$activeRfc =  $vs->getRfcActive();
		//get datos serie de acuerdo al tipo de comprobabte expedido.
		
		if(!$data["tiposComprobanteId"])
		{
			$vs->Util()->setError(10047, "error");
		}

		if($vs->Util()->PrintErrors()){ return false; }
		
		if($notaCredito)
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie WHERE tiposComprobanteId = '2' AND empresaId = ".$_SESSION["empresaId"]." AND rfcId = '".$activeRfc."' AND consecutivo <= folioFinal AND serieId = ".$data["tiposSerieId"]." ORDER BY serieId DESC LIMIT 1");
		}
		else
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie WHERE tiposComprobanteId = ".$data["tiposComprobanteId"]." AND empresaId = ".$_SESSION["empresaId"]." AND rfcId = '".$activeRfc."' AND consecutivo <= folioFinal AND serieId = ".$data["tiposSerieId"]." ORDER BY serieId DESC LIMIT 1");
		}
		
		$serie = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		if(!$serie)
		{
			$vs->Util()->setError(10047, "error");
		}

		if($vs->Util()->PrintErrors()){ return false; }

		$folio = $serie["consecutivo"];
		$fecha = $this->Util()->FormatDateAndTime(time());
		
		if($_SESSION["empresaId"] == 403 || $_SESSION["empresaId"] == 404)
		{
//			$fecha = "2014-03-03 23:29:52";
		}

		//$fecha = "2012-12-31 22:55:52";
		
		//el tipo de comprobante lo determina tiposComprobanteId
		$tipoDeComprobante = $this->GetTipoComprobante($data["tiposComprobanteId"]);
		$data["comprobante"] = $this->InfoComprobante($data["tiposComprobanteId"]);

		$data["serie"] = $serie;
		$data["folio"] = $folio;
		$data["fecha"] = $fecha;
		$data["tipoDeComprobante"] = $tipoDeComprobante;
		$data["certificado"] = $serie["noCertificado"];

		//build informacion nodo emisor
		$myEmpresa = new Empresa;
		$myEmpresa->setEmpresaId($_SESSION["empresaId"], 1);
		$myEmpresa->setSucursalId($data["sucursalId"]);
		$nodoEmisor = $myEmpresa->GetSucursalInfo();

		$this->setRfcId($activeRfc);
		$nodoEmisorRfc = $this->InfoRfc();
		
		$data["nodoEmisor"]["sucursal"] = $nodoEmisor;
		$data["nodoEmisor"]["rfc"] = $nodoEmisorRfc;

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
						$vs->Util()->setError(10048, "error");
					}
				}
			}

			if($vs->Util()->PrintErrors()){ return false; }
			
		}
		$userId = $data["userId"];
																		 
		//build informacion nodo receptor
		
		if(!$data["fromNomina"])
		{
			$vs->setUserId($userId, 1);
			$nodoReceptor = $vs->GetUserInfo($userId);
		}
		else
		{
			$usuario = new Usuario;
			$usuario->setUsuarioId($userId);
			$nodoReceptor = $usuario->InfoUsuario();
		}

		$data["nodoReceptor"] = $nodoReceptor;
		//$this->Util()->DP($data);
		
		//check tipo de cambio
		switch($_SESSION["version"])
		{
			case "auto":
			case "v3":
			case "construc":
				include_once(DOC_ROOT.'/classes/cadena_original_v3.class.php');break;
			case "2": 	
				include_once(DOC_ROOT.'/classes/cadena_original_v2.class.php');break;
		}
		$cadena = new Cadena;				
		$cadenaOriginal = $cadena->BuildCadenaOriginal($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"]);
//		echo "ok|";
		$data["cadenaOriginal"] = utf8_encode($cadenaOriginal);
		$data["cadenaOriginal"] = $cadenaOriginal;
		
		$md5Cadena = utf8_decode($cadenaOriginal);
		
		//echo $md5Cadena;
		//echo "<br>";
		$md5 = sha1($md5Cadena);
		
		//cambios 29 junio 2011
//		echo $empresa["empresaId"];

	switch($data["metodoDePago"])
	{
				case "01": $data["metodoDePagoLetra"] = "Efectivo"; break;
				case "02": $data["metodoDePagoLetra"] = "Cheque"; break;
				case "03": $data["metodoDePagoLetra"] = "Transferencia"; break;
				case "04": $data["metodoDePagoLetra"] = "Tarjetas de Credito"; break;
				case "05": $data["metodoDePagoLetra"] = "Monederos electronicos"; break;
				case "06": $data["metodoDePagoLetra"] = "Dinero electronico"; break;
				case "08": $data["metodoDePagoLetra"] = "Vales de despensa"; break;
				case "28": $data["metodoDePagoLetra"] = "Tarjeta de Debito"; break;
				case "29": $data["metodoDePagoLetra"] = "Tarjeta de Servici"; break;
				case "99": $data["metodoDePagoLetra"] = "Otros"; break;
	}

		if(!$data["fromNomina"])
		{
				include_once(DOC_ROOT."/classes/disenios_facturase_previa.php");
		}
		else
		{
				include_once(DOC_ROOT."/classes/disenios_facturase_previa_nomina.php");
		}
		return true;
	}//VistaPreviaComprobante
	
}



?>