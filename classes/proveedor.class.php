<?php

class Proveedor extends Sucursal
{

	function GetProveedores()
	{
		$sql = "SELECT COUNT(*) FROM proveedor 
				ORDER BY rfc";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/proveedores");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		
		$sql = "SELECT * FROM proveedor 
				ORDER BY rfc ".$sqlAdd;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		$data["items"] = $result;
		$data["pages"] = $pages;

		return $data;
	}

	
}//Producto


?>