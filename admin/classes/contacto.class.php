<?php 

class Contacto extends Main
{
	private $idContacto;
	private $nombre;
	private $email;
	private $telefono;
	private $texto;

	public function setIdContacto($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idContacto = $value;
	}

	public function getIdContacto()
	{
		return $this->idContacto;
	}

	public function setNombre($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'nombre');
		$this->nombre = $this->Util->EncodeSpanish($value);
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function setEmail($value)
	{
		$this->Util()->ValidateMail($value);
		$this->email = $this->Util->EncodeSpanish($value);
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setTelefono($value)
	{
		$this->Util()->ValidateString($value, 10000, 0, 'telefono');
		$this->telefono = $this->Util->EncodeSpanish($value);
	}

	public function getTelefono()
	{
		return $this->telefono;
	}

	public function setTexto($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'texto');
		$this->texto = $this->Util->EncodeSpanish($value);
	}

	public function getTexto()
	{
		return $this->texto;
	}

	public function Enumerate()
	{
		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM contacto");
		$total = $this->Util()->DB()->GetSingle();
		
		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/contacto/lista");

		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		
		$this->Util()->DB()->setQuery('SELECT * FROM contacto ORDER BY idContacto DESC '.$sql_add);
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
			$result[$key]["texto"] = nl2br($result[$key]["texto"]);
		}
		
		$data["items"] = $result;
		$data["pages"] = $pages;
		return $data;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM contacto WHERE idContacto = '".$this->idContacto."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				contacto
			SET
				`idContacto` = '".$this->idContacto."',
				`nombre` = '".$this->nombre."',
				`email` = '".$this->email."',
				`telefono` = '".$this->telefono."',
				`texto` = '".$this->texto."'
			WHERE idContacto = '".$this->idContacto."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$config = $this->Config();
		$from = $this->email;
		$headers = "From: $from";
		mail($config["email"], "Nuevo mensaje en el sistema", $this->texto, $headers);

		$this->Util()->DB()->setQuery("
			INSERT INTO
				contacto
			(
				`idContacto`,
				`nombre`,
				`email`,
				`telefono`,
				`texto`
		)
		VALUES
		(
				'".$this->idContacto."',
				'".$this->nombre."',
				'".$this->email."',
				'".$this->telefono."',
				'".$this->texto."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20000, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				contacto
			WHERE
				idContacto = '".$this->idContacto."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(20002, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>