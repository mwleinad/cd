<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa");
$result = $db->GetResult();

$count = 1;
?>
<?php
$total = 0;
foreach($result as $key => $res)
{
		$_SESSION['empresaId'] = $res["empresaId"];
		$util->DBSelect($res["empresaId"])->setQuery("SELECT noCertificado, xml, rfc FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId
			WHERE status = '0' AND fecha > '2016-02-16'");
		$facturas = $util->DBSelect($res["empresaId"])->GetResult();		
		
		foreach($facturas as $row)
		{
			$xml = $row["xml"];
			
			$rfcActivo = $rfc->getRfcActive();
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/SIGN_".$xml.".xml";
			
			$fh = fopen($root, 'r');
			$theData = fread($fh, filesize($root));
			fclose($fh);
			$theData = explode("UUID", $theData);
			$theData = $theData[1];
			$uuid = substr($theData, 2, 36);
		
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/";
			if ($handle = opendir($root)) 
			{
				while (false !== ($file = readdir($handle))) 
				{
					$ext = substr($file, -3);
					 if($ext == "pfx")
					 {
						 $key = $file;
					 }
				}
			}
			
			$path = $root.$key;
			
			$user = USER_PAC;
			$pw = PW_PAC;
			$pac = new Pac;
		
			//Get password
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/password.txt";		
			$fh = fopen($root, 'r');
			$password = fread($fh, filesize($root));
			
			fclose($fh);
		
			if(!$password)
			{
				continue;
			}
			$rfc->setRfcId($rfcActivo);
			$nodoEmisorRfc = $rfc->InfoRfc();
						
			$response = $pac->CancelaCfdi($user, $pw, $nodoEmisorRfc["rfc"], $uuid, $path, $password);			
			
			if($response !== true)
			{
				$nocancelables["uuis"] = $uuid; 
				$nocancelables["empresa"] = $row; 
				$nocancelables["response"] = $response; 
			}
		}
	

}

print_r($nocancelables);
