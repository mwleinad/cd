<?php
class Comisionista extends Main
{
	private $tipo;
	private $id;
	private $cantidad;
	private $status;
	

	public function setTipo($value)
	{
		$this->tipo = $value;
	}

	public function getTipo()
	{
		return $this->tipo;
	}
	public function setStatus($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'status');
		$this->status = $value;
	}

	public function getStatus()
	{
		return $this->status;
	}
	public function setCantidad($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'cantidad');
		$this->cantidad = $value;
	}

	public function getCantidad()
	{
		return $this->cantidad;
	}
	
	public function setId($value)
	{
		$this->id = $value;
	}
	
	public function setporcentaje($value)
	{
		$this->porcentaje = $value;
	}
	
	public function setpagado($value)
	{
		$this->pagado = $value;
	}
	
	public function setadeudo($value)
	{
		$this->adeudo = $value;
	}

	public function getId()
	{
		return $this->id;
	}
	
	
	
	public function OrdenesLista()
	{
		global $months;
		switch($_GET["orderBy"])
		{
			/*case "id": $orderBy = "empresa.empresaId DESC";break;
			case "activado": $orderBy = "empresa.activadoEl DESC";break;
			case "vencimiento": $orderBy = "empresa.vencimiento ASC";break;
			case "socio": $orderBy = "empresa.socioId ASC, empresa.empresaId DESC";break;
			case "version": $orderBy = "empresa.version ASC";break;*/
			default: $orderBy = "empresa.empresaId DESC";break;
			
		}
		
		$this->Util()->DB()->setQuery('SELECT * FROM empresa 
				LEFT JOIN usuario ON usuario.empresaId = empresa.empresaId 
				GROUP BY empresa.empresaId										
				ORDER BY '.$orderBy);
				
		//print_r($this->Util->DB()->query);
				
		$result = $this->Util()->DB()->GetResult();
		
		//print_r($result);
		foreach($result as $key => $empresa)
		{
			//print_r($empresa);
			if($empresa["empresaId"] == 15 || $empresa["empresaId"] == 22 || $empresa["empresaId"] == 39 || $empresa["empresaId"] == 63 || $empresa["empresaId"] == 116)
			{
				unset($result[$key]);
				continue;
			}

			if($empresa["tipoSocio"] == "cliente")
			{
			unset($result[$key]);
			continue;
			}

			$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM empresa WHERE empresaId = '".$empresa["socioId"]."'");
			$countSocioId = $this->Util()->DB()->GetSingle();

			if($countSocioId)
			{
				$this->Util()->DBSelect($empresa["socioId"])->setQuery("SELECT * FROM facturas_".$empresa["socioId"].".rfc LIMIT 1");
				$result[$key]["socio"] = $this->Util()->DBSelect($empresa["socioId"])->GetRow();
			}
			else
			{
				$result[$key]["socio"]["razonSocial"] = "Facturase";
			}
			
			$result[$key]["socio"]["razonSocial"] = utf8_decode($result[$key]["socio"]["razonSocial"]);

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT * FROM facturas_".$empresa["empresaId"].".rfc LIMIT 1");
			$result[$key]["rfc"] = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			
			$result[$key]["rfc"]["razonSocial"] = utf8_decode(urldecode($result[$key]["rfc"]["razonSocial"]));
//			$result[$key]["rfc"]["razonSocial"] = urldecode($result[$key]["rfc"]["razonSocial"]);
			
			switch($result[$key]["version"])
			{
				case 2: $result[$key]["version"] = "Medios Propios";break;
				case "v3": $result[$key]["version"] = "Empresarial";break;
				case "auto": $result[$key]["version"] = "CBB";break;
				case "ticgums": $result[$key]["version"] = "Medios Propios";break;
				case "avantika": $result[$key]["version"] = "Medios Propios";break;
				case "construc": $result[$key]["version"] = "Corporativo";break;
				case "demo": $result[$key]["version"] = "PAC";break;
				case "global": $result[$key]["version"] = "PAC";break;
			}


			//facturas expedidas
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM facturas_".$empresa["empresaId"].".comprobante WHERE empresaId = ".$empresa["empresaId"]." LIMIT 1");			
			$result[$key]["expedidos"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT fecha FROM facturas_".$empresa["empresaId"].".comprobante ORDER BY fecha DESC LIMIT 1");			
			$result[$key]["ultimaExpedida"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();
			
			$dateExploded = explode("-", $result[$key]["vencimiento"]);
			$result[$key]["vencimientoStamp"] = strtotime($result[$key]["vencimiento"]);
			
			if($result[$key]["vencimientoStamp"] < time())
			{
				$result[$key]["statusServicio"] = "Expirado";
			}
			elseif($result[$key]["vencimientoStamp"] < time() + 3600 * 24 *30)
			{
				$result[$key]["statusServicio"] = "PorExpirar";
			}
			
			$result[$key]["vencimiento"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];

			$dateExploded = explode("-", $result[$key]["activadoEl"]);
			$result[$key]["activadoEl"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];
			
			$result[$key]["terminar"] = 0;
 			if($result[$key]["limite"] - $result[$key]["expedidos"] < 20 && $result[$key]["limite"] > 10)
			{
				$result[$key]["terminar"] = 1;
			}

			 ////Agregado por jesus
			 //$this->Util()->DB()->setQuery('SELECT MAX(date) FROM log WHERE empresaId = "'.$empresa["empresaId"].'"');
				//print_r( $this->Util()->DB()->query);
				//$ultimolog = $this->Util()->DB()->GetSingle();

				//$semana = date("Y-m-d", strtotime('-1 week'));
				//$mes = date("Y-m-d", strtotime('-1 month'));
				//$ultimo = date("Y-m-d", strtotime($ultimolog));
				//if ($ultimo > $semana) 
					//	{
						//	$result[$key]["statusLog"] = "semana";
						//} 
					//else{
						//	if ($ultimo > $mes ) 
							//	{
								//$result[$key]["statusLog"] = "mes";
								//} 
							//else 
								//{
								//$result[$key]["statusLog"] = "mayor";
								//}
						//}
			 
		//}
		
		//if($_GET["orderBy"]=='ultimo'){
			//	$this->aasort($result,"statusLog");
				
		}

		
		//print_r($result);
		return $result;
	
	}
	
	
	
	
	
	
	
	public function aasort(&$array, $key) {
    		$sorter=array();
    		$ret=array();
    		reset($array);
    			foreach ($array as $ii => $va) {
        			$sorter[$ii]=$va[$key];
    			}
    
			arsort($sorter);
    			foreach ($sorter as $ii => $va) {
        			$ret[$ii]=$array[$ii];
    			}
    		$array=$ret;
		}
		
		
		







	public function showreferidos()
	{
		global $months;

		$this->Util()->DB()->setQuery('SELECT * FROM empresa 
				LEFT JOIN usuario ON usuario.empresaId = empresa.empresaId where socioId="'.$this->id.'"
										ORDER BY empresa.empresaId DESC ');
				
	
		$result = $this->Util()->DB()->GetResult();
		
		
		foreach($result as $key => $empresa)
		{
			//print_r($empresa);
			if($empresa["empresaId"] == 15 || $empresa["empresaId"] == 22 || $empresa["empresaId"] == 39 || $empresa["empresaId"] == 63 || $empresa["empresaId"] == 116)
			{
				unset($result[$key]);
				continue;
			}

			if($empresa["tipoSocio"] == "proveedor")
			{
			unset($result[$key]);
			continue;
			}

			$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM empresa WHERE empresaId = '".$empresa["socioId"]."'");
			$countSocioId = $this->Util()->DB()->GetSingle();

			if($countSocioId)
			{
				$this->Util()->DBSelect($empresa["socioId"])->setQuery("SELECT * FROM facturas_".$empresa["socioId"].".rfc LIMIT 1");
				$result[$key]["socio"] = $this->Util()->DBSelect($empresa["socioId"])->GetRow();
			}
			else
			{
				$result[$key]["socio"]["razonSocial"] = "Facturase";
			}
			
			$result[$key]["socio"]["razonSocial"] = utf8_decode($result[$key]["socio"]["razonSocial"]);

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT * FROM facturas_".$empresa["empresaId"].".rfc LIMIT 1");
			$result[$key]["rfc"] = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			
			$result[$key]["rfc"]["razonSocial"] = utf8_decode(urldecode($result[$key]["rfc"]["razonSocial"]));
//			$result[$key]["rfc"]["razonSocial"] = urldecode($result[$key]["rfc"]["razonSocial"]);
			
			switch($result[$key]["version"])
			{
				case 2: $result[$key]["version"] = "Medios Propios";break;
				case "v3": $result[$key]["version"] = "Empresarial";break;
				case "auto": $result[$key]["version"] = "CBB";break;
				case "ticgums": $result[$key]["version"] = "Medios Propios";break;
				case "avantika": $result[$key]["version"] = "Medios Propios";break;
				case "construc": $result[$key]["version"] = "Corporativo";break;
				case "demo": $result[$key]["version"] = "PAC";break;
				case "global": $result[$key]["version"] = "PAC";break;
			}


			//facturas expedidas
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM facturas_".$empresa["empresaId"].".comprobante WHERE empresaId = ".$empresa["empresaId"]." LIMIT 1");			
			$result[$key]["expedidos"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT fecha FROM facturas_".$empresa["empresaId"].".comprobante ORDER BY fecha DESC LIMIT 1");			
			$result[$key]["ultimaExpedida"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();
			
			$dateExploded = explode("-", $result[$key]["vencimiento"]);
			$result[$key]["vencimientoStamp"] = strtotime($result[$key]["vencimiento"]);
			
			if($result[$key]["vencimientoStamp"] < time())
			{
				$result[$key]["statusServicio"] = "Expirado";
			}
			elseif($result[$key]["vencimientoStamp"] < time() + 3600 * 24 *30)
			{
				$result[$key]["statusServicio"] = "PorExpirar";
			}
			
			$result[$key]["vencimiento"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];

			$dateExploded = explode("-", $result[$key]["activadoEl"]);
			$result[$key]["activadoEl"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];
			
			$result[$key]["terminar"] = 0;
 			if($result[$key]["limite"] - $result[$key]["expedidos"] < 20 && $result[$key]["limite"] > 10)
			{
				$result[$key]["terminar"] = 1;
			}	
		}
		return $result;
	
	}
	



















	public function FiltroTipo()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa ORDER BY empresaId ASC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}
	
	public function CancelarOrden()
	{
		$data = $this->DataEmpresa();
		if ($data == 0)
		{
			$valor = 1;
			$this->Util()->setError(20004, "complete");
		}
		elseif ($data == 1)
		{
			$valor = 0;
			$this->Util()->setError(20005, "complete");
		}
		else
		{
			return false;
		}
			$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`activo` = '".$valor."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function DataEmpresa()
	{
		$this->Util()->DB()->setQuery('SELECT activo FROM empresa WHERE empresaId = "'.$this->id.'"');
		$result = $this->Util()->DB()->GetSingle();
		return $result;
	}
	
	public function Log()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM log WHERE empresaId = "'.$this->id.'" ORDER BY date DESC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	
	}
	
	public function Referido()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM log WHERE empresaId = "'.$this->id.'" ORDER BY date DESC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}

		
	public function Data()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE empresaId = "'.$this->id.'"');
		$result = $this->Util()->DB()->GetRow();
		return $result;
	}
	
		
	

	public function AddLog()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$data = $this->Data();
		
		$fecha = date("Y-m-d H:i:s");
		
		$this->Util()->DB()->setQuery("
			INSERT INTO
				log
			(
				`comment`,
				`date`,
				`empresaId`
		)
		VALUES
		(
				'".$this->status."',
				'".$fecha."',
				'".$this->id."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20006, "complete", "Has agregado un log");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function Info()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE empresaId ="'.$this->id.'"');
		//print_r($this->Util()->DB->query);
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}
	
	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				empresa
			SET
			`porcentaje` = '".$this->porcentaje."',
				`pagado` = '".$this->pagado."',
				`adeudo` = '".$this->adeudo."'
			WHERE empresaId = '".$this->id."'");
		
		print_r($this->Util()->DB->query);
		
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function showreferidos2()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa LEFT JOIN usuario ON usuario.empresaId = empresa.empresaId where socioId ="'.$this->id.'"');

		$row = $this->Util()->DB()->GetRow();
		return $row;
	}
	
	
	public function AddFolios()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$data = $this->Data();
		$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`limite` = `limite` +'".$this->cantidad."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		
		$fecha = date("Y-m-d");
		
		$this->Util()->DB()->setQuery("
			INSERT INTO
				ventas
			(
				`cantidad`,
				`fecha`,
				`idSocio`,
				`idEmpresa`,
				`status`
		)
		VALUES
		(
				'".$this->cantidad."',
				'".$fecha."',
				'".$data['socioId']."',
				'".$data['empresaId']."',
				'".$this->status."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20006, "complete");
		$this->Util()->PrintErrors();
		return true;
	}	
}
?>