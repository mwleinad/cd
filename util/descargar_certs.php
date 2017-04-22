<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$empresas = array(698);
$implode = implode(",", $empresas);

$db->setQuery("SELECT empresaId FROM empresa");
$result = $db->GetResult();

    
		print_r($res);
		$zip = new ZipArchive();
		$zipRes = $zip->open(DOC_ROOT.'/empresas/certificados.zip', ZIPARCHIVE::OVERWRITE);

foreach($result as $key => $res)
{
	$directorio = DOC_ROOT.'/empresas/'.$res["empresaId"]."/certificados/1";
	
	if(!is_dir($directorio))
	{
		continue;
	}
	$ficheros1  = scandir($directorio);
	
	foreach($ficheros1 as $fichero)
	{
		if($fichero == "." || $fichero == "..")
		{
			continue;
		}
		if(is_dir($fichero))
		{
			continue;
		}

	
		if ($zipRes === TRUE) 
		{
			$zip->addFile($directorio."/".$fichero, $res["empresaId"]."/".$fichero);
		}

	}
}
			$zip->close();

?>