<?php 

class Ventas extends Main
{
	private $idVenta;
	private $cantidad;
	private $fecha;
	private $idSocio;
	private $status;
	private $idEmpresa;
	private $fechaPagado;
	public  $disponibles;
	
	public function setDisponibles($value){
	  if($value<$this->cantidad){
	  $this->Util()->setError(1, "complete","Error no puedes No te quedan suficientes folios disponibles");
	  }
	
	}

	public function setIdVenta($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idVenta = $value;
	}

	public function getIdVenta()
	{
		return $this->idVenta;
	}

	public function setCantidad($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->cantidad = $value;
	}

	public function getCantidad()
	{
		return $this->cantidad;
	}

	public function setFecha($value)
	{
		$this->Util()->ValidateString($value, 10000, 0, 'fecha');
		$this->fecha = $value;
	}

	public function getFecha()
	{
		return $this->fecha;
	}

	public function setIdSocio($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idSocio = $value;
	}

	public function getIdSocio()
	{
		return $this->idSocio;
	}

	public function setStatus($value)
	{
		$this->status = $value;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setIdEmpresa($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idEmpresa = $value;
	}

	public function getIdEmpresa()
	{
		return $this->idEmpresa;
	}

	public function setFechaPagado($value)
	{
		$this->Util()->ValidateString($value, 10000, 0, 'fechaPagado');
		$this->fechaPagado = $value;
	}

	public function getFechaPagado()
	{
		return $this->fechaPagado;
	}

	public function Enumerate()
	{
		if($_SESSION['tipo']=='partner' || $_SESSION['tipo']=='partnerPro' || $_SESSION['tipo']=='comisionista'){
		$filtro=" AND idSocio='".$_SESSION['loginKey']."'";
		}
		
		if($_SESSION["loginKey"] == 1)
		{
			$this->Util()->DB()->setQuery('SELECT COUNT(*) FROM ventas WHERE 1 '.$filtro);
		}
		else
		{
			$this->Util()->DB()->setQuery('SELECT COUNT(*) FROM ventas WHERE 1 AND mostrar = "Si" '.$filtro);
		}
		$total = $this->Util()->DB()->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/ventas");
        
		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		if($_SESSION["loginKey"] == 1)
		{
			$this->Util()->DB()->setQuery('SELECT * FROM ventas 
			LEFT JOIN socio ON socio.socioId = ventas.idSocio WHERE 1 '.$filtro.'														
																	ORDER BY idVenta DESC '.$sql_add);
		}
		else
		{
			$this->Util()->DB()->setQuery('SELECT * FROM ventas 
			LEFT JOIN socio ON socio.socioId = ventas.idSocio WHERE 1 AND mostrar = "Si"  '.$filtro.'														
																	ORDER BY idVenta DESC '.$sql_add);
		}
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
			$this->Util()->DB()->setQuery("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".DB_PREFIX.$row["idEmpresa"]."'");
			$dbExists = $this->Util()->DB()->GetSingle();
			
			if(!$dbExists)
			{
				continue;
			}
			$this->Util()->DBSelect($row["idEmpresa"])->setQuery("SELECT * FROM ".DB_PREFIX.$row["idEmpresa"].".rfc LIMIT 1");
			
			
			$result[$key]["rfc"] = $this->Util()->DBSelect($row["idEmpresa"])->GetRow();
			
			$result[$key]["rfc"]["razonSocial"] = urldecode($result[$key]["rfc"]["razonSocial"]);
			
			$result[$key]["idSocio"] = $result[$key]["nombre"];
			
		}
		$data["items"] = $result;
		$data["pages"] = $pages;
		return $data;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM ventas WHERE idVenta = '".$this->idVenta."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				ventas
			SET
				`idVenta` = '".$this->idVenta."',
				`status` = '".$this->status."',
				`fechaPagado` = '".date("Y-m-d")."'
			WHERE idVenta = '".$this->idVenta."'");
		$this->Util()->DB()->UpdateData();

		//checamos si la orden ya esta activa sino activar.
		$this->Util()->DB()->setQuery("
			SELECT idEmpresa FROM ventas WHERE idVenta = '".$this->idVenta."'");
		$idEmpresa = $this->Util()->DB()->GetSingle();

		$this->Util()->DB()->setQuery("
			SELECT cantidad FROM ventas WHERE idVenta = '".$this->idVenta."'");
		$cantidad = $this->Util()->DB()->GetSingle();

		if($this->status == "pagado")
		{
				$date = date("Y-m-d");
				//activamos empresa y updateamos fecha activado y fecha de 1er vencimiento
				$datePost = date("Y-m-d", strtotime($date. " + 1 YEAR"));
				
				$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET vencimiento = '".$datePost."', limite = limite + ".$cantidad." WHERE empresaId = ".$idEmpresa);
				
				$this->Util()->DB()->UpdateData();
				
		}

		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				ventas
			(
				`idVenta`,
				`cantidad`,
				`fecha`,
				`idSocio`,
				`status`,
				`idEmpresa`
		)
		VALUES
		(
				'".$this->idVenta."',
				'".$this->cantidad."',
				'".date("Y-m-d")."',
				'".$this->idSocio."',
				'noPagado',
				'".$this->idEmpresa."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		
		$subject = 'Se agregaron '.$this->cantidad.' nuevos timbres ';
		$body = "Para la empresa ".$this->idEmpresa.".\r\n";
		$body .= "Por el usuario ".$_SESSION["userName"].".\r\n";
		$sendMail = new SendMail;
		$sendMail->prepare($subject, $body);
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE 
				ventas
			SET mostrar = 'No'	
			WHERE
				idVenta = '".$this->idVenta."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>