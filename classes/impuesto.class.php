<?php 

class Impuesto extends Comprobante
{
	private $impuestoId;
	private $nombre;
	private $tasa;
	private $tipo;

	public function setImpuestoId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->impuestoId = $value;
	}

	public function getImpuestoId()
	{
		return $this->impuestoId;
	}

	public function setNombre($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'Nombre');
		$this->nombre = $value;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setTasa($value)
	{
		$this->Util()->ValidateString($value, $max_chars=10, $minChars = 1, "Tasa");
		$this->Util()->ValidateFloat($value, 6);
		$this->tasa = $value;
	}

	public function getTasa()
	{
		return $this->tasa;
	}

	public function setTipo($value)
	{
		$this->Util()->ValidateString($value, $max_chars=10, $minChars = 1, "Tipo");
		$this->tipo = $value;
	}

	public function getTipo()
	{
		return $this->tipo;
	}

	public function Enumerate()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM impuesto');
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/impuesto");

		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT * FROM impuesto ORDER BY tipo ASC, nombre ASC '.$sql_add);
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();

		foreach($result as $key => $row)
		{
		}
		$data["items"] = $result;
		$data["pages"] = $pages;
		return $data;
	}

	public function Info()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM impuesto WHERE impuestoId = '".$this->impuestoId."'");
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			UPDATE
				impuesto
			SET
				`impuestoId` = '".$this->impuestoId."',
				`nombre` = '".$this->nombre."',
				`tasa` = '".$this->tasa."',
				`tipo` = '".$this->tipo."'
			WHERE impuestoId = '".$this->impuestoId."'");
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();

		$this->Util()->setError(20029, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			INSERT INTO
				impuesto
			(
				`impuestoId`,
				`nombre`,
				`tasa`,
				`tipo`
		)
		VALUES
		(
				'".$this->impuestoId."',
				'".$this->nombre."',
				'".$this->tasa."',
				'".$this->tipo."'
		);");
		$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
		$this->Util()->setError(20027, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			DELETE FROM
				impuesto
			WHERE
				impuestoId = '".$this->impuestoId."'");
		$this->Util()->DBSelect($_SESSION["empresaId"])->DeleteData();
		$this->Util()->setError(20028, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	
	function Suggest($value)
	{
		$empresa = $this->Info();
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM impuesto WHERE nombre LIKE '%".$value."%' ORDER BY nombre");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		foreach($result as $key => $periodo)
		{
		}
		return $result;
	}
	

}

?>