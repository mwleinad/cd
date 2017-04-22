<?php

class Main
{
	protected $page;


	public function setPage($value)
	{
		$this->Util()->ValidateInteger($value, 9999999999, 0);
		$this->page = $value;
	}
	
	public function getPage()
	{
		return $this->page;
	}

	public function Config()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM config");
		$config = $this->Util()->DB()->GetRow();
		return $config;
	}
	public function Util() 
	{
		if($this->Util == null ) 
		{
			$this->Util = new Util();
		}
		return $this->Util;
	}
	
	public function ListSocios()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM socio ORDER BY nombre ASC');
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
		}
		return $result;
	}
	
}


?>