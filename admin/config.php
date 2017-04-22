<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = $_SERVER['HTTP_HOST'];

if($docRoot == "/var/www/vhosts/comprobantedigital.mx/httpdocs")
{
	$docRoot = $docRoot."/sistema";
	$webRoot = $webRoot."/sistema";
	
	$sqlDatabase = "pascacio_general";
	$sqlUser = "admin";
	$sqlPassword = "Strong47";

	$userPac = "SACJ840515UPA";
	$pwPac = "wdyewpfkj";
	
//	$userPac = "STI070725SAA";
//	$pwPac = "oobrotcfl";

	$siteName = "CONFACTURA";
	$administrationName = "AVANTIKA";
	$administrationUrl = "http://www.avantika.com.mx";

	$dbPrefix = "pascacio_";
	$sqlHost = "localhost";
	
}
elseif($docRoot == "/var/www/vhosts/facturase.com/httpdocs")
{
	$docRoot = $docRoot;
	$webRoot = $webRoot;

	$sqlDatabase = "facturas_general";
	$sqlUser = "admin";
	$sqlPassword = "Strong47";
	
	$userPac = "SACJ840515UPA";
	$pwPac = "wdyewpfkj";

	$siteName = "FACTURASE";
	$administrationName = "TRAZZOS";
	$administrationUrl = "http://www.trazzos.com";

	$dbPrefix = "facturas_";
	$sqlHost = "localhost";

}
else
{
	$docRoot = $docRoot."/facturacion";
	$webRoot = $webRoot."/facturacion";
	
	$sqlDatabase = "facturas_general";
	$sqlUser = "root";
	$sqlPassword = "root";

	$userPac = "SACJ840515UPA";
	$pwPac = "wdyewpfkj";

	$siteName = "FACTURASE";
	$administrationName = "TRAZZOS";
	$administrationUrl = "http://www.trazzos.com";

	$dbPrefix = "facturas_";
	$sqlHost = "192.168.1.200";
}

define("DB_PREFIX", $dbPrefix);
define("DOC_ROOT", $docRoot."/admin");
define('WEB_ROOT', "http://".$webRoot."/admin");

define("SQL_HOST", $sqlHost);
define("SQL_DATABASE", $sqlDatabase);
define("SQL_USER", $sqlUser);
define("SQL_PASSWORD", $sqlPassword);

/*	$mailHost = "mail.facturase.com";
	$mailUser = "ventas@facturase.com";
	$mailPass = "Strong47-";
	$mailPort = "25";
*/
	$mailHost = "mail.comprobantedigital.mx";
	$mailUser = "ventas@comprobantedigital.mx";
	$mailPass = "Strong47-";
	$mailPort = "25";

define('SMTP_HOST', $mailHost);
define('SMTP_USER', $mailUser);
define('SMTP_PASS', $mailPass);
define('SMTP_PORT', $mailPort);


?>
