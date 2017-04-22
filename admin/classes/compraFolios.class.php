<?php 

class CompraFolios extends Main
{
	   public $usuarioId;
	   public $compraFoliosId;
	   public $paqFoliosId;
	   public $fecha;
	
	
	
	
	public function setUsuarioId($value){
			$this->usuarioId=$value;
	}
	
	public function setCompraFoliosId($value){
			$this->compraFoliosId=$value;
	}
	
	public function setPaqFoliosId($value){
			$this->paqFoliosId=$value;
	}
	
	public function setFecha($value){
			$this->fecha=$value;
	}
	
	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				compraFolios
			(
				`compraFoliosId`,
				`paqFoliosId`,
				`userId`,
				`fecha`
			)
		VALUES
		(
				'".$this->compraFoliosId."',
				'".$this->paqFoliosId."',
				'".$this->usuarioId."',
				'".$this->fecha."'
				
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20003, "complete","Se ha concretado la Adquisicion de Folios");
		$this->Util()->PrintErrors();
		return true;
	}
	

	
}

?>