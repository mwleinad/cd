<?php
class Vencimiento extends Main
{
	private $id;
	
	public function setId($value)
	{
		$this->id = $value;
	}
	
	public function ConsultaVencimiento()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE DateDiff("y",$activadoEl,now()) = 350 AND activo = "1" ORDER BY empresaId ASC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}
	
	public function ConsultaSuspencion()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE DateDiff("y",$activadoEl,now()) = 372 AND activo = "1" ORDER BY empresaId ASC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}
	
	public function GuardarVencimiento()
	{
		$data = $this->Data();
		$this->Util()->DB()->setQuery("
			INSERT INTO
				vencimiento
			(
				`empresaId`,
				`productId`,
				`socioId`,
				`proveedorId`
		)
		VALUES
		(
				'".$data['productId']."',
				'".$data['proveedorId']."',
				'".$data['socioId']."',
				'".$data['empresaId']."'
		)");
		$this->Util()->DB()->InsertData();
	}
	public function SuspenderVencimiento()
	{
		$data = $this->Data();
		$this->Util()->DB()->setQuery("
			UPDATE 
				vencimiento
			SET
				activo = '0'
			WHERE
				empresaId = '".$data['empresaId']."'
		");
		$this->Util()->DB()->UpdateData();
	}
	
	public function Data()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE empresaId = "'.$this->id.'"');
		$result = $this->Util()->DB()->GetRow();
		return $result;
	}
		

	
}
