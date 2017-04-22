<?php

class Util extends Error
{

	public function DB() 
	{
		if($this->DB == null ) 
		{
			$this->DB = new DB();
		}
		return $this->DB;
	}

	public function DBSelect($empresaId) 
	{
		if($this->DBSelect == null ) 
		{
			$this->DBSelect = new DB();
		}
		$this->DBSelect->setSqlDatabase(DB_PREFIX.$empresaId);
		return $this->DBSelect;
	}

	function RoundNumber($number)
	{
		return round($number, 6);
	}
	
	function FormatSeconds($sec, $padHours = false)
	{
	    $hms = "";
	    $hours = intval(intval($sec) / 3600); 
	    $hms .= ($padHours) 
    	      ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
        	  : $hours. ':';
	    $minutes = intval(($sec / 60) % 60); 
	    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
	    $seconds = intval($sec % 60); 
	    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
	    return $hms;
	}

	function FormatNumber($number, $dec = 2)
	{
		return number_format($number, $dec);
	}

	function FormatDateAndTime($time)
	{
		$time = date("Y-m-d H:i:s", $time);
	    return $time;
	}

	function FormatDateAndTimeSat($date)
	{
		$time = strtotime($date);
		$date = date("d/m/Y H:i:s", $time);
    return $date;
	}

	function FormatDate($time)
	{
		$time = date("Y-m-d", $time);
	    return $time;
	}

	function FormatDateMySql($date)
	{
		$date = explode("-", $date);
		return $date[2]."-".$date[1]."-".$date[0];
	}



	function ValidateInteger(&$number, $max = 0, $min = 0)
	{
		if (!preg_match("/^[0-9]+$/",$number)) $number = 0;

		if($min != 0 && $number < $min) 
		{ 
			$number = $min; 
			return; 
		}	

		if($max != 0 && $number > $max) 
		{ 
			$number = $max; 
			return; 
		}	
		
		if($number > 9223372036854775807)
		{
			$number = 9223372036854775807;
		}
	}
	
	function ValidateFloat(&$number, $decimals = 2, $max = 0, $min = 0)
	{
		if (!is_numeric($number))
		{
			$number=0;
		}

		$number=round($number, $decimals);
	
		if($max != 0 && $number > $max)
		{ 
			$number = $max; 
			return; 
		}	

		if($min != 0 && $number < $min)
		{ 
			$number = $min; 
			return; 
		}	

		if($number>9223372036854775807) 
		{
			$number=9223372036854775807;
		}
	}
	
 function CheckDomain($domain,$server,$findText)
 {
		// Open a socket connection to the whois server
		$con = fsockopen($server, 43);
		if (!$con)
		{	
			return false;
		}
    // Send the requested doman name
    fputs($con, $domain."\r\n");
        
		// Read and store the server response
		$response = ' :';
		while(!feof($con)) {
				$response .= fgets($con,128); 
		}
        
		fclose($con);
        
		// Check the response stream whether the domain is available
		if (strpos($response, $findText)){
				return true;
		}
		else {
				return false;   
		}
  }	

	function ValidateString(&$string, $max_chars=5000, $minChars = 1, $field = null)
	{
		$string=htmlspecialchars($string, ENT_QUOTES);
		
		if(strlen($string)<$minChars)
		{
			return $this->setError(10000, "error", "", $field);
		}
			
		if(strlen($string)>$max_chars)
		{
			$string = substr($string,0,$max_chars);
		}
	}	


	function ValidateMail($mail)
	{
		$mail = strtolower($mail);
		if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/',trim($mail)))
		{
			return $this->setError(10002, "error", "", "EMail");
		}
	}	

	function ValidateUrl($url)
	{
		if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))
		{
			return $this->error = 10001;
		}
	}

	function ValidateFile($pathToFile)
	{
		$handle = @fopen($pathToFile, "r");
		if ($handle === false)
		{
			return $this->error = 10003;
		}
		fclose($handle);
	}

	function wwwRedirect()
	{
		if(!preg_match("/^www./", $_SERVER['HTTP_HOST']))
		{
		//	header("location: ".WEB_ROOT);
		}
	}
	
	function MakeTime($day, $month, $year)
	{
		return mktime(0,0,0, $month, $day, $year);
	}
	
	function CreateDropDown($name, $from, $to, $selectedIndex)
	{
		$select = "<select name='".$name."' id='".$name."'>";
		for($ii=$from; $ii <= $to; $ii++)
		{
			if($selectedIndex == $ii)
			  $select.= "<option value='".$ii."' selected='selected'>".$ii."</option>";
			else
				$select.= "<option value='".$ii."'>".$ii."</option>"; 
		}
		$select.= "</select>";	 
		return $select;
	}

	function GetCurrentYear()
	{
		return date("Y", time());
	}
	
	function GetCents($num)
	{
		$cents = ($num - floor($num))*100;
		$cents = ceil($cents);
		if($cents < 10)
			$cents = "0".$cents;
		return $cents;
	}	
	
	function num2letras($num, $fem = true, $dec = true) 
	{ 
		 $matuni[2]  = "dos"; 
		 $matuni[3]  = "tres"; 
		 $matuni[4]  = "cuatro"; 
		 $matuni[5]  = "cinco"; 
		 $matuni[6]  = "seis"; 
		 $matuni[7]  = "siete"; 
		 $matuni[8]  = "ocho"; 
		 $matuni[9]  = "nueve"; 
		 $matuni[10] = "diez"; 
		 $matuni[11] = "once"; 
		 $matuni[12] = "doce"; 
		 $matuni[13] = "trece"; 
		 $matuni[14] = "catorce"; 
		 $matuni[15] = "quince"; 
		 $matuni[16] = "dieciseis"; 
		 $matuni[17] = "diecisiete"; 
		 $matuni[18] = "dieciocho"; 
		 $matuni[19] = "diecinueve"; 
		 $matuni[20] = "veinte"; 
		 $matunisub[2] = "dos"; 
		 $matunisub[3] = "tres"; 
		 $matunisub[4] = "cuatro"; 
		 $matunisub[5] = "quin"; 
		 $matunisub[6] = "seis"; 
		 $matunisub[7] = "sete"; 
		 $matunisub[8] = "ocho"; 
		 $matunisub[9] = "nove"; 
	
		 $matdec[2] = "veint"; 
		 $matdec[3] = "treinta"; 
		 $matdec[4] = "cuarenta"; 
		 $matdec[5] = "cincuenta"; 
		 $matdec[6] = "sesenta"; 
		 $matdec[7] = "setenta"; 
		 $matdec[8] = "ochenta"; 
		 $matdec[9] = "noventa"; 
		 $matsub[3]  = 'mill'; 
		 $matsub[5]  = 'bill'; 
		 $matsub[7]  = 'mill'; 
		 $matsub[9]  = 'trill'; 
		 $matsub[11] = 'mill'; 
		 $matsub[13] = 'bill'; 
		 $matsub[15] = 'mill'; 
		 $matmil[4]  = 'millones'; 
		 $matmil[6]  = 'billones'; 
		 $matmil[7]  = 'de billones'; 
		 $matmil[8]  = 'millones de billones'; 
		 $matmil[10] = 'trillones'; 
		 $matmil[11] = 'de trillones'; 
		 $matmil[12] = 'millones de trillones'; 
		 $matmil[13] = 'de trillones'; 
		 $matmil[14] = 'billones de trillones'; 
		 $matmil[15] = 'de billones de trillones'; 
		 $matmil[16] = 'millones de billones de trillones'; 
	
		 $num = trim((string)@$num); 
		 if ($num[0] == '-') { 
				$neg = 'menos '; 
				$num = substr($num, 1); 
		 }else 
				$neg = ''; 
		 while ($num[0] == '0') $num = substr($num, 1); 
		 if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
		 $zeros = true; 
		 $punt = false; 
		 $ent = ''; 
		 $fra = ''; 
		 for ($c = 0; $c < strlen($num); $c++) { 
				$n = $num[$c]; 
				if (! (strpos(".,'''", $n) === false)) { 
					 if ($punt) break; 
					 else{ 
							$punt = true; 
							continue; 
					 } 
	
				}elseif (! (strpos('0123456789', $n) === false)) { 
					 if ($punt) { 
							if ($n != '0') $zeros = false; 
							$fra .= $n; 
					 }else 
	
							$ent .= $n; 
				}else 
	
					 break; 
	
		 } 
		 $ent = '     ' . $ent; 
		 if ($dec and $fra and ! $zeros) { 
				$fin = ' coma'; 
				for ($n = 0; $n < strlen($fra); $n++) { 
					 if (($s = $fra[$n]) == '0') 
							$fin .= ' cero'; 
					 elseif ($s == '1') 
							$fin .= $fem ? ' una' : ' un'; 
					 else 
							$fin .= ' ' . $matuni[$s]; 
				} 
		 }else 
				$fin = ''; 
		 if ((int)$ent === 0) return 'Cero ' . $fin; 
		 $tex = ''; 
		 $sub = 0; 
		 $mils = 0; 
		 $neutro = false; 
		 while ( ($num = substr($ent, -3)) != '   ') { 
				$ent = substr($ent, 0, -3); 
				if (++$sub < 3 and $fem) { 
					 $matuni[1] = 'una'; 
					 $subcent = 'as'; 
				}else{ 
					 $matuni[1] = $neutro ? 'un' : 'uno'; 
					 $subcent = 'os'; 
				} 
				$t = ''; 
				$n2 = substr($num, 1); 
				if ($n2 == '00') { 
				}elseif ($n2 < 21) 
					 $t = ' ' . $matuni[(int)$n2]; 
				elseif ($n2 < 30) { 
					 $n3 = $num[2]; 
					 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
					 $n2 = $num[1]; 
					 $t = ' ' . $matdec[$n2] . $t; 
				}else{ 
					 $n3 = $num[2]; 
					 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
					 $n2 = $num[1]; 
					 $t = ' ' . $matdec[$n2] . $t; 
				} 
				$n = $num[0]; 
				if ($n == 1) { 
					 $t = ' ciento' . $t; 
				}elseif ($n == 5){ 
					 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
				}elseif ($n != 0){ 
					 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
				} 
				if ($sub == 1) { 
				}elseif (! isset($matsub[$sub])) { 
					 if ($num == 1) { 
							$t = ' mil'; 
					 }elseif ($num > 1){ 
							$t .= ' mil'; 
					 } 
				}elseif ($num == 1) { 
					 $t .= ' ' . $matsub[$sub] . '?n'; 
				}elseif ($num > 1){ 
					 $t .= ' ' . $matsub[$sub] . 'ones'; 
				}   
				if ($num == '000') $mils ++; 
				elseif ($mils != 0) { 
					 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
					 $mils = 0; 
				} 
				$neutro = true; 
				$tex = $t . $tex; 
		 } 
		 $tex = $neg . substr($tex, 1) . $fin; 
		 return ucfirst($tex); 
	} 
	
	function ImprimeNoFolio($folio)
	{
		return sprintf("%05d", $folio);
	}

	function ConvertirMes($mes)
	{
		$mesArray = array("N/A", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
		return $mesArray[$mes];
	}	
	
	function LoadPage($page, $extendible = "")
	{
			header("location: ".WEB_ROOT."/".$page.$extendible);
	}
	
	function Today()
	{
		return date("Y-m-d");
	}
	
	function ExtractPeriod()
	{
		$today = $this->Today();
		$this->DB()->setQuery("SELECT periodoId FROM periodo WHERE status = 'activo'");
		
		$period = $this->DB()->GetSingle();
		
		if($period == 0)
		{
			$period = 1;
		}
		
		return $period;
	}
	
	function GetReservationDays($in, $out)
	{
		$entrada = explode("-", $in);
		$entrada[2] = str_replace(" 00:00:00", "", $entrada[2]);
		
		$fechaEntrada = $this->MakeTime($entrada[2], $entrada[1], $entrada[0]);
		
		$salida = explode("-", $out);
		$salida[2] = str_replace(" 00:00:00", "", $salida[2]);
		$fechaSalida = $this->MakeTime($salida[2], $salida[1], $salida[0]);		
		
		return $days = ($fechaSalida - $fechaEntrada) / (3600 * 24);
	}
	
	function LoadUrl($url)
	{
			header("location: ".$url);
	}


function HandleMultipages($page,$total,$link,$items_per_page=0,$pagevar="p"){

	if(!$items_per_page)
		$items_per_page = ITEMS_PER_PAGE;

	$pages["items_per_page"] = $items_per_page;

	if(empty($page)){
		$page = 0;
	}//if

	$pages["start"] = $page*$items_per_page;
	$pages["end"]   = $pages["start"] + $items_per_page;
	if($pages["end"] > $total){
		$pages["end"] = $total;
	}//if

	if($total%$items_per_page == 0){
		$total_pages = $total/$items_per_page - 1;
		if($total_pages < 0){
			$total_pages = 0;
		}//if
	}//if
	else{
		$total_pages = (int)($total/$items_per_page);
	}//else

	if($page > 0){
		if(!$this->hs_eregi("\|$pagevar\|",$link))
		$pages["prev"] = $link."/".$pagevar."/".($page-1);
		else
		$pages["prev"] = $this->hs_ereg_replace("\|$pagevar\|",(string)($page-1),$link);
	}//if

	if($total_pages > 0){
		if($total_pages > 15){
			$start = $page - 7;
			if($start < 0)
				$start = 0;
			$end = $start + 15;
			if($end > $total_pages){
				$end = $total_pages;
				$start = $end - 15;
			}//if
		}//if
		else{
			$start = 0;
			$end = $total_pages;
		}//else
		for($i=$start;$i<=$end;$i++){
			if(!$this->hs_eregi("\|$pagevar\|",$link))
			$pages["numbers"][$i+1] = $link."/".$pagevar."/".$i;
			else
			$pages["numbers"][$i+1] = $this->hs_ereg_replace("\|$pagevar\|",(string)$i,$link);
		}//for
	}//if

	if($page < $total_pages){
		if(!$this->hs_eregi("\|$pagevar\|",$link))
		$pages["next"] = $link."/".$pagevar."/".($page+1);
		else
		$pages["next"] = hs_ereg_replace("\|$pagevar\|",(string)($page+1),$link);
	}//if
	
	if($start > 0){
		if(!$this->hs_eregi("\|$pagevar\|",$link))
		$pages["first"] = $link."/".$pagevar."/0";
		else
		$pages["first"] = hs_ereg_replace("\|$pagevar\|","0",$link);
	}
	
	if($end < $total_pages){
		if(!$this->hs_eregi("\|$pagevar\|",$link))
		$pages["last"] = $link."/".$pagevar."/".$total_pages;
		else
		$pages["last"] = hs_ereg_replace("\|$pagevar\|",(string)($total_pages),$link);
	}

	$pages["current"] = $page+1;

	return $pages;

}//handle_multipages

	function hs_eregi($var1,$var2,$var3 = null){
		
		if(function_exists("mb_eregi"))
			return mb_eregi($var1,$var2,$var3);
		else
			return eregi($var1,$var2,$var3);
		
	}//hs_eregi


	function hs_ereg_replace($var1,$var2,$var3){
		
		if(function_exists("mb_ereg_replace"))
			return mb_ereg_replace($var1,$var2,$var3);
		else
			return ereg_replace($var1,$var2,$var3);
		
	}//hs_ereg_replace

	function SexoString($sex)
	{
		switch($sex)
		{
			case "m": $sexo = "Masculino";break;
			case "f": $sexo = "Femenino";break;
			default: $sexo = "Masculino";
		}
		return $sexo;
	}
	function CalculateIva($price)
	{
		return $price * (IVA / 100);
	}
	
	function ReturnLang()
	{
		if(!$_SESSION['lang'])
		{
			$lang = "es";
		}
		elseif($_SESSION['lang'] == "es")
		{
			$lang = "es";
		}
		else
		{
			$lang = "en";
		}
		
		return $lang;
	}
	
	function FormatOutputText(&$text)
	{
		$text = nl2br($text);
	}
	
	function SetIp()
	{
		if ($_SERVER) 
		{
			if ( $_SERVER["HTTP_X_FORWARDED_FOR"] ) 
			{
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			}
			elseif ( $_SERVER["HTTP_CLIENT_IP"] )
			{
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			}
			else
			{
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		}
		else
		{
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) 
			{
				$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
			} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) 
			{
					$realip = getenv( 'HTTP_CLIENT_IP' );
			} else 
			{
				$realip = getenv( 'REMOTE_ADDR' );
			}
		}
		
		return $realip;
	
	}	
	
	function validateDateFormat($date, $field)
	{
		//match the format of the date
		if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $date, $parts))
		{ 
			//check weather the date is valid of not
					if(checkdate($parts[2],$parts[1],$parts[3]))
						return true;
					else
					 return $this->setError(10011, "error", "", $field);
		}
		else
			return $this->setError(10011, "error", "", $field);
	}
	
	function DP($variable)
	{
		echo "<pre>";
		print_r($variable);
		echo "</pre>";
	}
	
	function CadenaOriginalVariableFormat($cadena, $formatNumber = false, $addPipe = true)
	{
		//change tabs, returns and newlines into spaces
		$cadena = utf8_encode(urldecode($cadena));
		$cadena = str_replace("|","/",$cadena);
		$remove = array("\t", "\n", "\r\n", "\r");
    $cadena = str_replace($remove, ' ', $cadena);
		
		$pat[0] = "/^\s+/";
		$pat[1] = "/\s{2,}/";
		$pat[2] = "/\s+\$/";
		$rep[0] = "";
		$rep[1] = " ";
		$rep[2] = "";
		$cadena = preg_replace($pat,$rep,$cadena);

		if($formatNumber)
		{
			$cadena = number_format($cadena, 2, ".", "");
		}
		
		if(strlen($cadena) > 0 && $addPipe)
		{
			$cadena .= "|";
		}
		return $cadena = trim($cadena);
	}
	
	function CadenaOriginalPDFFormat($cadena, $formatNumber = false, $addPipe = true)
	{
		//change tabs, returns and newlines into spaces
		$cadena = utf8_encode(urldecode($cadena));
		$cadena = str_replace("|","/",$cadena);
//		$remove = array("\t", "\n", "\r\n", "\r");
//    $cadena = str_replace($remove, ' ', $cadena);
		
		$pat[0] = "/^\s+/";
		$pat[1] = "/\s{2,}/";
		$pat[2] = "/\s+\$/";
		$rep[0] = "";
		$rep[1] = " ";
		$rep[2] = "";
		$cadena = preg_replace($pat,$rep,$cadena);

		if($formatNumber)
		{
			$cadena = number_format($cadena, 2, ".", "");
		}
		
		if(strlen($cadena) > 0 && $addPipe)
		{
			$cadena .= "|";
		}
		return $cadena = trim($cadena);
	}
	
	function DecodeVal($value){
		
		return urldecode($value);
		
	}//decodeVal
	
	//new
	function Wrap($string, $lenght)
	{
		$wrapped = wordwrap($string, $lenght);
		return $wrapped;
	}

	function ShortString($string, $lenght)
	{
		$string = html_entity_decode($string);
		$string = strip_tags($string);
		$wrapped = substr($string, 0, $lenght);
		return $wrapped;
	}

	function DecodeString($string)
	{
		$string = html_entity_decode($string);
		$string = strip_tags($string);
		$string = utf8_encode($string);
		return $string;
	}
	
	function EncodeSpanish($string)
	{
		$string = utf8_decode($string);
		return $string;
	}
	
	function orderMultiDimensionalArray ($toOrderArray, $field, $inverse = false) {
		
		$position = array();
		$newRow = array();
		foreach ($toOrderArray as $key => $row) {
				$position[$key]  = $row[$field];
				$newRow[$key] = $row;
		}
		if ($inverse) {
			arsort($position);
		}
		else {
			asort($position);
		}
		$returnArray = array();
		foreach ($position as $key => $pos) {     
			$returnArray[] = $newRow[$key];
		}
		return $returnArray;
		
	}	

}


?>