<?php

class Shop extends User
{
	private $type;
	private $itemId;
	
	public function setType($value)
	{
		$validTypes = array('armor', 'helmet', 'boot', 'weapon', 'shield', 'relic');
		
		if(!in_array($value, $validTypes))
		{
				$this->Util()->setError(10032, "error", "");
				return;
		}
		$this->type = $value;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setItemId($value, $checkIfPublic = 1)
	{
		$this->Util()->ValidateInteger($value);

		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM game_items WHERE item_id=".$value);

		if($checkIfPublic)
		{
			$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM game_items WHERE item_id=".$value." AND belongs_to=0");
		}
		
		if(0 >= $this->Util()->DB()->GetSingle())
		{
			$this->Util()->setError(10033, "error", "");
			return;
		}
		
		$this->itemId = $value;
	}

	public function getItemId()
	{
		return $this->itemId;
	}

	function View()
	{
		$info = $this->info();
		$lang = $this->Util->ReturnLang();

		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM game_items WHERE type = '".$this->type."' AND city_id = ".$info["actual_city"]);
		$total = $this->Util()->DB()->GetSingle();
		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/tale/shops/".$this->type);
		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$this->Util()->DB()->setQuery("SELECT * FROM game_items WHERE type = '".$this->type."' AND city_id = ".$info["actual_city"]." ORDER BY prestige_mode ASC, level ASC, cost DESC ".$sql_add);
		
		$items = $this->Util()->DB()->GetResult();
		
		foreach($items as $key => $value)
		{
			//$items[$key]["post"] = html_entity_decode($blogs[$key]["post"]);
			//$blogs[$key]["link"] = ($blogs[$key]["post"]);
		}
		
		$data["items"] = $items;
		$data["pages"] = $pages;
		return $data;
	}
	
	function ItemInfo()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM game_items WHERE item_id = '".$this->itemId."'");
		$item = $this->Util()->DB()->GetRow();
		
		return $item;
	}
	
	function BuyItem()
	{
		global $property;
		if($this->Util()->PrintErrors()){ return false; }	
		
		$info = $this->Info();
		$item = $this->ItemInfo();
		
		if($item["city_id"] != $info["actual_city"])
		{
			$this->Util()->setError(10034, "error");
			if($this->Util()->PrintErrors()){ return false; }						
		}
		$user = new User;
		$user->setUserId($info["user_id"], 1);
		$inventory = $user->inventory();
		
		if($inventory["total"] >= $info["maxInventory"])
		{
			$this->Util()->setError(10035, "error");
			if($this->Util()->PrintErrors()){ return false; }						
		}

		if($info["copper"] < $item["cost"])
		{
			$this->Util()->setError(10036, "error");
			if($this->Util()->PrintErrors()){ return false; }						
		}

		$this->Util()->DB()->setQuery("
			INSERT INTO  `inventory` (
				`inv_id` ,
				`user_id` ,
				`item_id` ,
				`uses_left` ,
				`type` ,
				`equipped` ,
				`clan_id` ,
				`market`
				)
				VALUES (
				NULL ,  
				'".$info["user_id"]."',  
				'".$item["item_id"]."',  
				'".$item["uses"]."',  
				'".$item["type"]."',  
				'0',  
				'0',  
				'0')");
		$this->Util()->DB()->InsertData();

		$this->Util()->DB()->setQuery("UPDATE users SET copper = copper - ".$item["cost"]." WHERE user_id = ".$info["user_id"]);
		$this->Util()->DB()->UpdateData();
		
		$this->Util()->setError(NULL, "complete", $property["language"]["youHaveAddedAnItemToYourInventory"]."<a href='".WEB_ROOT."/tale/inventory'>".$property["language"]["inventory"]."<a>");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function Util() 
	{
		if($this->Util == null ) 
		{
			$this->Util = new Util();
		}
		return $this->Util;
	}
	
}



?>
