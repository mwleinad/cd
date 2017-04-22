<?php

function SortByDate($a, $b)
{
	$fechaA = strtotime($a["fecha"]);
	$fechaB = strtotime($b["fecha"]);
	
	if($fechaA == $fechaB)
	{
		return 0;
	}
	
	return ($fechaA < $fechaB) ? -1 : 1;
}

class Reporte extends Sucursal
{
	private $mes;
	private $anio;
	
	public function setMes($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->mes = $value;
	}
	
	public function getMes()
	{
		return $this->mes;
	}	

	public function setAnio($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->anio = $value;
	}
	
	public function getAnio()
	{
		return $this->anio;
	}	

	function GenerarReporteSat()
	{
		echo "ok|";
		//solo se generan para el rfc activo.
		$rfcActivo = $this->getRfcActive();
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante WHERE MONTH(fecha) = '".$this->mes."' AND YEAR(fecha) = '".$this->anio."' AND rfcId ='".$rfcActivo."' ORDER BY fecha ASC");
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		foreach($result as $key => $res)
		{
			$result[$key]["comprobanteActivo"] = "si";
			$result[$key]["status"] = "1";
			//unset($result[$key]["cadenaOriginal"]);
		}

		//seleecionamos tambien los cancelados
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante WHERE ((MONTH(fechaPedimento) = '".$this->mes."' AND YEAR(fechaPedimento) = '".$this->anio."') OR fechaPedimento IS NULL) AND status = '0' AND rfcId ='".$rfcActivo."' ORDER BY fechaPedimento ASC");
		$resultCancelados = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		foreach($resultCancelados as $key => $res)
		{
			if(!$res["fechaPedimento"])
			{
				$res["fecha"] = explode(" ", $res["fecha"]);
				$resultCancelados[$key]["fechaPedimento"] = $res["fecha"][0];
			}
			
			$dateCancelado = explode("-", $resultCancelados[$key]["fechaPedimento"]);

			if($dateCancelado[0] != $this->anio)
			{
				continue;
			}

			if($dateCancelado[1] != $this->mes)
			{
				continue;
			}
			
			$resultCancelados[$key]["comprobanteActivo"] = "no";
			unset($resultCancelados[$key]["cadenaOriginal"]);
		}
//		print_r($resultCancelados);

		$result = array_merge($result, $resultCancelados);
		usort($result, "SortByDate");


		if(!$result)
		{
			echo "fail|";
			echo "No hay comprobantes para el mes seleccionado";
			return;
		}
		
		//build nombre del archivo
		//esquema
		$filename = 1;
		
		//rfc del emisor
		$this->setRfcId($rfcActivo);
		$rfc = $this->InfoRfc();
		$filename .= $rfc["rfc"];

		//mes y anio
		$mes = $this->mes;
		if($mes < 10)
		{
			$mes = "0".$mes;
		}
		
		$filename .= $mes.$this->anio.".txt";
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/";
		
		$data["path"] = $root;
		$data["txt"] = $filename;

		$strFinal = "";
		foreach($result as $comprobante)
		{
			if($comprobante["tiposComprobanteId"] == 6 || $comprobante["tiposComprobanteId"] == 7)
			{
				continue;
			}
			
			switch($comprobante["tipoDeComprobante"])
			{
				case "ingreso": $comprobante["efectoComprobante"] = "I"; break;
				case "egreso": $comprobante["efectoComprobante"] = "E"; break;
				case "traslado": $comprobante["efectoComprobante"] = "T"; break;
			}
			
			$str = "";
			
			$str .= "|";
			//inicio registro
			//build partes
			//1) rfc del cliente
			//get rfc del cliente
			$cliente = new Cliente();
			$cliente->setUserId($comprobante["userId"]);
			$myCliente = $cliente->InfoCliente();
			$str .= $myCliente["rfc"]."|";

			//serie
			$str .= $comprobante["serie"]."|";

			//folio
			$str .= $comprobante["folio"]."|";
			
			//anio aprobacion
			$str .= $comprobante["anoAprobacion"];
			
			//no aprobacion
			$str .= $comprobante["noAprobacion"]."|";

			//fecha y hora de expedicion
			$str .= $this->Util()->FormatDateAndTimeSat($comprobante["fecha"])."|";

			//monto de la operacion
			$str .= $this->Util()->CadenaOriginalVariableFormat($comprobante["total"], true, false)."|";

			//monto del impuesto
			$str .= $this->Util()->CadenaOriginalVariableFormat($comprobante["ivaTotal"], true, false)."|";
						
			//estado comprobante
			$strStatus = $comprobante["status"]."|";
			
			$str2 = '';
									
			//efecto comprobante
			$str2 .= $comprobante["efectoComprobante"]."|";

			//pedimento
			$str2 .= $comprobante["pedimento"]."|";

			//fecha pedimento
			$str2 .= "|";

			//aduana
			$str2 .= $comprobante["aduana"]."|";

			//salto de linea
			$str2 .= "\r\n";
			
			$strFinal .= $str.$strStatus.$str2;

		}


		$fp = fopen ($root.$filename, "w+");
   	fwrite($fp, $strFinal);
		fclose($fp);
		
//		print_r($data);
		return $data;
	}
}


?>