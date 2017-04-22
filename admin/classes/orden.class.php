<?php 

class Orden extends Main
{
	private $idOrden;
	private $fecha;
	private $idSocio;
	private $status;
	private $idEmpresa;
	

	public function setIdOrden($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idOrden = $value;
	}

	public function getIdOrden()
	{
		return $this->idOrden;
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

	public function Enumerate()
	{
	
	if($_SESSION['tipo']=='partner' || $_SESSION['tipo']=='partnerPro' || $_SESSION['tipo']=='comisionista'){
		$filtro=" where idSocio='".$_SESSION['loginKey']."'";
		}
		$this->Util()->DB()->setQuery('SELECT COUNT(*) FROM orden'.$filtro);
		$total = $this->Util()->DB()->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/orden");

		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		$this->Util()->DB()->setQuery('SELECT * FROM orden 
			LEFT JOIN socio ON socio.socioId = orden.idSocio '.$filtro.'													
			ORDER BY idOrden DESC '.$sql_add);
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
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
		$this->Util()->DB()->setQuery("SELECT * FROM orden WHERE idOrden = '".$this->idOrden."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				orden
			SET
				`idOrden` = '".$this->idOrden."',
				`fechaPagado` = '".date("Y-m-d")."',
				`status` = '".$this->status."'
			WHERE idOrden = '".$this->idOrden."'");
		$this->Util()->DB()->UpdateData();

		//checamos si la orden ya esta activa sino activar.
		$this->Util()->DB()->setQuery("
			SELECT idEmpresa FROM orden WHERE idOrden = '".$this->idOrden."'");
		$idEmpresa = $this->Util()->DB()->GetSingle();
		
		$this->Util()->DB()->setQuery("
			SELECT * FROM empresa WHERE empresaId = '".$idEmpresa."'");
		$empresa = $this->Util()->DB()->GetRow();
		
		
		//updateamos a un anio el vencimiento
		if($this->status == "pagado")
		{
			if($empresa["activo"] == 0)
			{
				$date = date("Y-m-d");
				//activamos empresa y updateamos fecha activado y fecha de 1er vencimiento
				
//				SET activo = '1', activadoEl = '".$date."', vencimiento = DATE_ADD('".$date."', INTERVAL 1 YEAR) WHERE empresaId = ".$idEmpresa);
				$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET activo = '1', activadoEl = '".$date."' WHERE empresaId = ".$idEmpresa);
				$this->Util()->DB()->UpdateData();
				
			}
			else
			{
				$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET vencimiento = DATE_ADD(vencimiento, INTERVAL 1 YEAR) WHERE empresaId = ".$idEmpresa);
				$this->Util()->DB()->UpdateData();
				
			}
		
		}
		
		$this->Util()->setError(2, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				orden
			(
				`fecha`,
				`idSocio`,
				`status`,
				`idEmpresa`
		)
		VALUES
		(
				'".date("Y-m-d")."',
				'".$this->idSocio."',
				'noPagado',
				'".$this->idEmpresa."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				orden
			WHERE
				idOrden = '".$this->idOrden."'");
//		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(3, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>