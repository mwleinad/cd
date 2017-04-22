<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT * FROM empresa WHERE borrar = '1' OR activo = '0' ORDER BY empresaId ASC");
$result = $db->GetResult();
echo count($result);

//todos los directorios actuales
$dirs = glob('../empresas/*', GLOB_ONLYDIR);

$noExiste = array();

foreach($dirs as $key => $dir)
{
	$name = explode("/", $dir);
	
	$db->setQuery("SELECT * FROM empresa WHERE empresaId = '".$name[2]."'");
	$result = $db->GetRow();
	
	if(!$result)
	{
		array_push($noExiste, $name[2]);
		//print_r($name[2]);
		//echo "empresa no existe en base de datos";
	}
	
}
print_r($noExiste);

$noExiste = array();
foreach($dirs as $key => $dir)
{
	$name = explode("/", $dir);
	
	$db->setQuery("SELECT borrar FROM empresa WHERE empresaId = '".$name[2]."' AND borrar = 'Si'");
	$result = $db->GetRow();
	
	if($result)
	{
		//numero de facturas
		$util->DBSelect($name[2])->setQuery("
			SELECT COUNT(*) FROM comprobante"
		);
		$facturas = $util->DBSelect($name[2])->GetSingle();

		$util->DBSelect($name[2])->setQuery("
			SELECT razonSocial FROM rfc"
		);
		$razonSocial = $util->DBSelect($name[2])->GetSingle();

		array_push($noExiste, array($name[2], $facturas, $razonSocial));

		//print_r($name[2]);
		//echo "empresa no existe en base de datos";
	}
	
}
print_r($noExiste);

//mas de un anio sin facturar
$noExiste = array();
foreach($dirs as $key => $dir)
{
	$name = explode("/", $dir);
	
	$db->setQuery("SELECT empresaId, activo, version FROM empresa WHERE empresaId = '".$name[2]."'");
	$result = $db->GetRow();
	
	if($result)
	{
		//numero de facturas
		$util->DBSelect($name[2])->setQuery("
			SELECT fecha FROM comprobante ORDER by comprobanteId DESC"
		);
		$fecha = $util->DBSelect($name[2])->GetSingle();
		
		//un anio atras
		$anio = time() - (3600 * 24 * 365);
		$compare = strtotime($fecha);

		if($compare < $anio && $compare != 0)
		{

			$util->DBSelect($name[2])->setQuery("
				SELECT COUNT(*) FROM comprobante"
			);
			$facturas = $util->DBSelect($name[2])->GetSingle();
			
			$util->DBSelect($name[2])->setQuery("
				SELECT razonSocial FROM rfc"
			);
			$razonSocial = $util->DBSelect($name[2])->GetSingle();
	
			array_push($noExiste, array($name[2], $result["activo"], $result["version"], $fecha, $facturas, $razonSocial));
		}

		//print_r($name[2]);
		//echo "empresa no existe en base de datos";
	}
	
}
print_r($noExiste);
	
?>