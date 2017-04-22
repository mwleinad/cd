<?php

class ComplementoNomina extends Main
{
	function GenerarCadena($data)
	{
		if($data["nodoReceptor"]["fechaInicioRelLaboral"] == "0000-00-00")
		{
			$data["nodoReceptor"]["fechaInicioRelLaboral"] = "1969-01-01";
		}
		
		if(!$data["nodoReceptor"]["periodicidadPago"])
		{
			$data["nodoReceptor"]["periodicidadPago"] = "Quincenal";
		}
		
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat(VERSION_NOMINA, false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["registroPatronal"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numEmpleado"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["curp"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoRegimen"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numSeguridadSocial"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["numDiasPagados"], true);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["departamento"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["clabe"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["banco"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["fechaInicioRelLaboral"], false);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["antiguedad"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["puesto"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoContrato"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoJonada"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["periodicidadPago"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioBaseCotApor"], true);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["riesgoPuesto"], false);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioDiarioIntegrado"], true);
		
		//nodo percepciones
		if(count($_SESSION["percepciones"]) > 0)
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"], true);
		
			foreach($_SESSION["percepciones"] as $percepcion)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["tipoPercepcion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["tipoPercepcion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["nombrePercepcion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["importeGravado"], true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($percepcion["importeExcento"], true);
			}
		}
		
		//nodo deducciones
		if(count($_SESSION["deducciones"]) > 0)
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"], true);
			
			foreach($_SESSION["deducciones"] as $deduccion)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["tipoDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["tipoDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["nombreDeduccion"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["importeGravado"], true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($deduccion["importeExcento"], true);
			}
		}
		
		if(count($_SESSION["incapacidades"]) > 0)
		{
			foreach($_SESSION["incapacidades"] as $incapacidad)
			{
				//checar si dias necesita 6 decimales
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["diasIncapacidad"], true);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["tipoIncapacidad"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($incapacidad["descuento"], true);
			}
		}
		

		if(count($_SESSION["horasExtras"]) > 0)
		{
			foreach($_SESSION["horasExtras"] as $horaExtra)
			{
				//checar si dias necesita 6 decimales
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["dias"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["tipoHoras"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["horasExtra"], false);
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($horaExtra["importePagado"], true);
			}
		}
		return $cadenaOriginal;
	}//VistaPreviaComprobante
	
}



?>