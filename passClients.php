<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

	$source = '/var/www/vhosts/facturase.com/httpdocs/3/empresas';
	$dest = DOC_ROOT."/empresas";
	
	$empresas = array(63);
	
	foreach($empresas as $empresa)
	{
		$source = $source."/".$empresa;
		$dest = $dest."/".$empresa;
		
		$util->xcopy($source, $dest, $permissions = 0777);
	}
exit;