<?php

	$docRoot = $_SERVER['DOCUMENT_ROOT'];
	$webRoot = $_SERVER['HTTP_HOST'];

	$docRoot = $docRoot.'/facturacion';
	$webRoot = $webRoot.'/facturacion';

	if($docRoot == '/var/www/html/facturacion'){
		$sqlDatabase = 'facturas_general';
		$sqlUser = 'root';
		$sqlPassword = 'root';
	}else{
		$sqlDatabase = 'facturas_general';
		$sqlUser = 'root';
		$sqlPassword = '';
	}

	$userPac = 'SACJ840515UPA';
	$pwPac = 'pfkjwdyew';

	$siteName = 'FACTURASE';
	$administrationName = 'TRAZZOS';
	$administrationUrl = 'http://www.trazzos.com';

	$dbPrefix = 'facturas_';

	define('DB_PREFIX', $dbPrefix);
	define('DOC_ROOT', $docRoot);
	define('WEB_ROOT', 'http://'.$webRoot);
		
	define('USER_PAC', $userPac);
	define('PW_PAC', $pwPac);
		
	define('SQL_HOST', 'localhost');
	define('SQL_DATABASE', $sqlDatabase);
	define('SQL_USER', $sqlUser);
	define('SQL_PASSWORD', $sqlPassword);

?>
