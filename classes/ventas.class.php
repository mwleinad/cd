<?php 

class Ventas extends Comprobante
{
	private $idVenta;
	private $cantidad;
	private $fecha;
	private $idSocio;
	private $status;
	private $idEmpresa;

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
		$this->Util()->ValidateString($value, 10000, 1, 'fecha');
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
		$this->Util()->DB()->setQuery('SELECT COUNT(*) FROM ventas');
		$total = $this->Util()->DB()->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/ventas");

		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		$this->Util()->DB()->setQuery('SELECT * FROM ventas ORDER BY idVenta ASC '.$sql_add);
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
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
				`cantidad` = '".$this->cantidad."',
				`fecha` = '".$this->fecha."',
				`idSocio` = '".$this->idSocio."',
				`status` = '".$this->status."',
				`idEmpresa` = '".$this->idEmpresa."'
			WHERE idVenta = '".$this->idVenta."'");
		$this->Util()->DB()->UpdateData();

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
				'".$this->fecha."',
				'".$this->idSocio."',
				'".$this->status."',
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
				ventas
			WHERE
				idVenta = '".$this->idVenta."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>