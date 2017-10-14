<?php

class ComplementoNomina extends Main
{
	function GenerarCadena($data)
	{
		global $horasExtraImporte;
		if($data["nodoReceptor"]["fechaInicioRelLaboral"] == "0000-00-00")
		{
			$data["nodoReceptor"]["fechaInicioRelLaboral"] = "1969-01-01";
		}
		
		if(!$data["nodoReceptor"]["periodicidadPago"])
		{
			$data["nodoReceptor"]["periodicidadPago"] = "Quincenal";
		}
		
if($data["nodoReceptor"]["periodicidadPago"] != 99)
{
	$tipoNomina = "O";
}
else
{
	$tipoNomina = "E";
}		
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat(VERSION_NOMINA_12, false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($tipoNomina, false);

		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["numDiasPagados"], true, true, false, true);

		$horasExtraImporte = 0;
		if(count($_SESSION["horasExtras"]) > 0)
		{
			foreach($_SESSION["horasExtras"] as $myHoraExtra)
			{
				$horasExtraImporte += $myHoraExtra["importePagado"];
			}	
		}
				
		$totalPercepciones = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"] + $horasExtraImporte;
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalPercepciones, true);

		$totalDeducciones = $_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"] + $_SESSION["conceptos"]["1"]["incapacidades"]["total"];
		if($totalDeducciones > 0)
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalDeducciones, true);
		}

		$totalOtrosPagos = 0;
		foreach($_SESSION["otrosPagos"] as $key => $value)
		{
			$totalOtrosPagos += $value["importe"];
		}

		if($totalOtrosPagos > 0)
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalOtrosPagos, true);
		}
		
		//nodo emisor
		if(strlen($data["nodoEmisor"]["rfc"]["rfc"]) == 13 && strlen($data["nodoEmisor"]["rfc"]["curp"]) > 0)
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["curp"], false);
		}
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["registroPatronal"], false);

		//nodo receptor
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["curp"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numSeguridadSocial"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["fechaInicioRelLaboral"], false);
		
		$antiguedad = $this->Util()->weeks($data["nodoReceptor"]["fechaInicioRelLaboral"], $data["fechaPago"]);
		$antiguedad = "P".$antiguedad."W";
		
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($antiguedad, false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoContrato"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoJonada"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoRegimen"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numEmpleado"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["departamento"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["puesto"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["riesgoPuesto"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["periodicidadPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioBaseCotApor"], true);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioDiarioIntegrado"], true);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["estado"], false);
		
		//nodo percepciones
		if(count($_SESSION["percepciones"]) > 0)
		{
//			$totalSueldos = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"];


		$totalSueldos = 0;
		$totalSeparacionIndemnizacion = 0;
		$totalJubilacionPensionRetiro = 0;
		foreach($_SESSION["percepciones"] as $myPercepcion)
		{
			if($myPercepcion["tipoPercepcion"] != "022" &&
				$myPercepcion["tipoPercepcion"] != "023" &&
				$myPercepcion["tipoPercepcion"] != "025" &&
				$myPercepcion["tipoPercepcion"] != "039" &&
				$myPercepcion["tipoPercepcion"] != "044") {
				$totalSueldos += $myPercepcion["importeGravado"] + $myPercepcion["importeExcento"];
			}
			
			if($myPercepcion["tipoPercepcion"] == "022" ||
				$myPercepcion["tipoPercepcion"] == "023" ||
				$myPercepcion["tipoPercepcion"] == "025") {
				$totalSeparacionIndemnizacion += $myPercepcion["importeGravado"] + $myPercepcion["importeExcento"];
			}
			
			if($myPercepcion["tipoPercepcion"] == "039" ||
				$myPercepcion["tipoPercepcion"] == "044") {
				$totalJubilacionPensionRetiro += $myPercepcion["importeGravado"] + $myPercepcion["importeExcento"];
			}		

		}
		$totalSueldos = $totalSueldos + $horasExtraImporte;
		$totalGravado = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $horasExtraImporte;
			
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalSueldos, true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalSeparacionIndemnizacion, true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalJubilacionPensionRetiro, true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalGravado, true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"], true);
		
			foreach($_SESSION["percepciones"] as $percepcion)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["tipoPercepcion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["tipoPercepcion"], false); //clave
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["nombrePercepcion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["importeGravado"], true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["importeExcento"], true);
			}
		}
		
		if(count($_SESSION["horasExtras"]) > 0)
		{
			foreach($_SESSION["horasExtras"] as $horaExtra)
			{
//				print_r($horaExtra);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("019", false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("003", false); //clave
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("Horas Extra", false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["importePagado"], true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("0", true);

				if($horaExtra["dias"] == 0)
				{
					$horaExtra["dias"] = 1;
				}

				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["dias"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["tipoHoras"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["horasExtra"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["importePagado"], true);
			}
		}
		
if($totalSeparacionIndemnizacion > 0){
		$aniosServicio = ceil($this->Util()->weeks($data["nodoReceptor"]["fechaInicioRelLaboral"], $data["fechaPago"]) / 52);
		$ingresoAcumulable = 0;
		if($totalSueldos > $totalSeparacionIndemnizacion) {
			$ingresoAcumulable = $totalSeparacionIndemnizacion;
		} else {
			$ingresoAcumulable = $totalSueldos;
		}
		
		$ingresoNoAcumulable = $totalSeparacionIndemnizacion - $totalSueldos;
		
		if($ingresoNoAcumulable < 0) {
			$ingresoNoAcumulable = 0;
		}
		
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalSeparacionIndemnizacion, false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($aniosServicio, false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalSueldos, false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($ingresoAcumulable, true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($ingresoNoAcumulable, true);
}		
		//nodo deducciones
		$totalOtrasDeducciones = 0;
		if(count($_SESSION["deducciones"]) > 0)
		{
			foreach($_SESSION["deducciones"] as $myDeduccion)
			{
				if($myDeduccion["tipoDeduccion"] == "002" || $myDeduccion["tipoDeduccion"] == "022")
				{
					$totalImpuestosRetenidos += $myDeduccion["importeExcento"] + $myDeduccion["importeGravado"];
				}
				else
				{
					$totalOtrasDeducciones += $myDeduccion["importeExcento"] + $myDeduccion["importeGravado"];
				}
			}
			
			if(count($_SESSION["incapacidades"]) > 0)
			{
				foreach($_SESSION["incapacidades"] as $myIncapacidad)
				{	
					$totalOtrasDeducciones += $myIncapacidad["descuento"];
				}
			}
			
			
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalOtrasDeducciones, true);
			if($totalImpuestosRetenidos > 0)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalImpuestosRetenidos, true);
			}
			
			foreach($_SESSION["deducciones"] as $deduccion)
			{
				$importe = $deduccion["importeGravado"] + $deduccion["importeExcento"];
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["tipoDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["tipoDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["nombreDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($importe, true);
			}
		}
		
		if(count($_SESSION["otrosPagos"]) > 0)
		{
			foreach($_SESSION["otrosPagos"] as $myOtroPago)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["tipoOtroPago"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["tipoOtroPago"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["nombreOtroPago"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true);
				
				if($myOtroPago["tipoOtroPago"] == "002")
				{
					$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true);
				}
				
				if($myOtroPago["tipoOtroPago"] == "004")
				{
					$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true);
					$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat(date("Y"), false);
					$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("0", true);
				}
			}
		}		
		
		if(count($_SESSION["incapacidades"]) > 0)
		{
			foreach($_SESSION["incapacidades"] as $incapacidad)
			{
				//checar si dias necesita 6 decimales
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["diasIncapacidad"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["tipoIncapacidad"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["descuento"], true);
			}
		}
		
		

		return $cadenaOriginal;
	}//VistaPreviaComprobante
	
}



?>