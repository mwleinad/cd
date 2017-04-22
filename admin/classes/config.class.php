<?php 

class Config extends Main
{
	private $email;
	private $idConfig;

	public function setEmail($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'email');
		$this->email = $value;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setIdConfig($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idConfig = $value;
	}

	public function getIdConfig()
	{
		return $this->idConfig;
	}

	public function setHome($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Home');
		$this->home = $this->Util->EncodeSpanish($value);
	}

	public function getHome()
	{
		return $this->home;
	}

	public function setNosotros($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Nosotros');
		$this->nosotros = $this->Util->EncodeSpanish($value);
	}

	public function getNosotros()
	{
		return $this->nosotros;
	}

	public function setMision($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Mision');
		$this->mision = $this->Util->EncodeSpanish($value);
	}

	public function getMision()
	{
		return $this->mision;
	}

	public function setVision($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Vision');
		$this->vision = $this->Util->EncodeSpanish($value);
	}

	public function getVision()
	{
		return $this->Vision;
	}

	public function setValores($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Valores');
		$this->valores = $this->Util->EncodeSpanish($value);
	}

	public function getValores()
	{
		return $this->valores;
	}

	public function setLaborSocial($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Labor Social');
		$this->laborSocial = $this->Util->EncodeSpanish($value);
	}

	public function getLaborSocial()
	{
		return $this->laborSocial;
	}

	public function setEventos($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Eventos');
		$this->eventos = $this->Util->EncodeSpanish($value);
	}

	public function getEventos()
	{
		return $this->eventos;
	}

	public function setFormatos($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'Formatos');
		$this->formatos = $this->Util->EncodeSpanish($value);
	}

	public function getFormatos()
	{
		return $this->formatos;
	}
	
	public function setProducto($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'producto');
		$this->producto = $this->Util->EncodeSpanish($value);
	}

	public function getProducto()
	{
		return $this->producto;
	}
	
		public function setCompetencia($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'competencia');
		$this->competencia = $this->Util->EncodeSpanish($value);
	}

	public function getCompetencia()
	{
		return $this->competencia;
	}
	
		public function setBeneficios($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'beneficios');
		$this->beneficios = $this->Util->EncodeSpanish($value);
	}

	public function getBeneficios()
	{
		return $this->beneficios;
	}
	
		public function setFunciona($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'funciona');
		$this->funciona = $this->Util->EncodeSpanish($value);
	}

	public function getFunciona()
	{
		return $this->funciona;
	}
	
		public function setPreguntas($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'preguntas');
		$this->preguntas = $this->Util->EncodeSpanish($value);
	}

	public function getPreguntas()
	{
		return $this->preguntas;
	}


	public function setCarrusel($value)
	{
		$this->Util()->ValidateString($value, 1000000, 1, 'carrusel');
		$this->carrusel = $this->Util->EncodeSpanish($value);
	}

	public function getCarrusel()
	{
		return $this->carrusel;
	}




	public function Enumerate()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM config ORDER BY idConfig ASC');
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
		}
		return $result;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM config WHERE idConfig = '".$this->idConfig."'");
		$row = $this->Util()->DB()->GetRow();
		
		$row["homeHTML"] = htmlentities($row["home"]);
		$row["nosotrosHTML"] = htmlentities($row["nosotros"]);
		$row["misionHTML"] = htmlentities($row["mision"]);
		$row["visionHTML"] = htmlentities($row["vision"]);
		$row["laborSocialHTML"] = htmlentities($row["laborSocial"]);
		$row["valoresHTML"] = htmlentities($row["valores"]);
		$row["eventosHTML"] = htmlentities($row["eventos"]);
		$row["formatosHTML"] = htmlentities($row["formatos"]);
		return $row;
	}

	public function Edit()
	{
//		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				config
			SET
				`email` = '".$this->email."',
				`home` = '".$this->home."',
				`nosotros` = '".$this->nosotros."',
				`mision` = '".$this->mision."',
				`vision` = '".$this->vision."',
				`eventos` = '".$this->eventos."',
				`valores` = '".$this->valores."',
				`laborSocial` = '".$this->laborSocial."',
				`formatos` = '".$this->formatos."',
				`funciona` = '".$this->funciona."',
				`producto` = '".$this->producto."',
				`beneficios` = '".$this->beneficios."',
				`preguntas` = '".$this->preguntas."',
				`competencia` = '".$this->competencia."',
				`carrusel` = '".$this->carrusel."',
				`idConfig` = '".$this->idConfig."'
			WHERE idConfig = '".$this->idConfig."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				config
			(
				`email`,
				`idConfig`
		)
		VALUES
		(
				'".$this->email."',
				'".$this->idConfig."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20003, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				config
			WHERE
				idConfig = '".$this->idConfig."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(20002, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

}

?>