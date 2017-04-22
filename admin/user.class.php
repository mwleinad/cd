<?php

class User 
{
	protected $userId = NULL;

	public function setUserId($value, $checkIfExists = 0)
	{
		$empresa = $this->Info();
		$this->Util()->ValidateInteger($value);
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM cliente WHERE userId ='".$value."' AND empresaId = ".$empresa["empresaId"]);
		if($checkIfExists)
		{
			if($this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle() <= 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		else
		{
			if($this->Util()->DB()->GetSingle() > 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		$this->userId = $value;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	//private functions
	function GetUserInfo()
	{
		if(!$this->userId)
		{
			$this->userId = 0;
		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM cliente WHERE userId = ".$this->userId);
		return $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
	}

	//private functions
	public function GetUserIdBy($value, $field = "username")
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT userId FROM cliente WHERE ".$field."='".$value."'");
		return $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
	}

	public function Suggest($value)
	{
		$this->Util()->DBSelect($this->getEmpresaId())->setQuery("SELECT userId, nombre, rfc FROM cliente WHERE rfcId = '".$this->getRfcId()."' AND rfc LIKE '%".$value."%'ORDER BY nombre LIMIT 5");
		$result =  $this->Util()->DBSelect($this->getEmpresaId())->GetResult();
		
		return $result;
	}

}

?>
