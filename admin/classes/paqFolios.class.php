<?php

class PaqFolios extends Main
{
	public $paqFoliosId;
	public $nombre;
	public $cantidad;
	public $monto;
	

	public function setPaqFoliosId($value)
	{
		$this->paqFoliosId = $value;
	}
	public function setNombre($value){
	$this->Util()->ValidateString($value, 10000, 5, 'Descripcion');
	  $this->nombre=$value;
	}
	
	public function setCantidad($value){
	   
	  $this->cantidad=$value;	
	}
	
	public function setMonto($value){
	  $this->monto=$value;
	}
	
	public function Enumerate(){
			$sql="select * from paqFolios";
			$this->Util()->DB()->setQuery($sql);
			return $this->Util()->DB()->GetResult();
	}
	
	public function Info(){
			$sql="select * from paqFolios where paqFoliosId='".$this->paqFoliosId."'";
			$this->Util()->DB()->setQuery($sql);
			return $this->Util()->DB()->GetRow();
			
	}
	
	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				paqFolios
			(
				
				`nombre`,
				`cantidad`,
				`monto`
				
		)
		VALUES
		(
				
				'".$this->nombre."',
				'".$this->cantidad."',
				'".$this->monto."'
			
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20003, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				paqFolios
			SET
			`nombre` = '".$this->nombre."',
			`cantidad` = '".$this->cantidad."',
		    `monto` = '".$this->monto."'
				WHERE paqFoliosId = '".$this->paqFoliosId."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	
}	

?>