<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = $_SERVER['HTTP_HOST'];

if($docRoot == "/home/confactura/domains/confactura.com.mx/public_html")
{
	$docRoot = $docRoot."/2";
	$webRoot = $webRoot."/2";
	
	$sqlDatabase = "confactura_1";
	$sqlUser = "da_admin";
	$sqlPassword = "lacimadel2000";
	$sqlHost = "localhost";
	
	$userPac = "STI070725SAA";
	$pwPac = "oobrotcfl";

	$siteName = "CONFACTURA";
	$administrationName = "AVANTIKA";
	$administrationUrl = "http://www.avantika.com.mx";

	$dbPrefix = "confactura_";
	
	$mailHost = "mail.avantika.com.mx";
	$mailUser = "smtp3@avantika.com.mx";
	$mailPass = "avantikaSMTP3";
	$mailPort = "587";
	
}
elseif($docRoot == "/var/www/vhosts/facturase.com/httpdocs")
{
	$docRoot = $docRoot."/sistema";
	$webRoot = $webRoot."/sistema";

	$sqlDatabase = "facturas_general";
	$sqlUser = "admin";
	$sqlPassword = "Strong47";
	$sqlHost = "localhost";
	
	$userPac = "SACJ840515UPA";
	$pwPac = "pfkjwdyew";

	$siteName = "FACTURASE";
	$administrationName = "TRAZZOS";
	$administrationUrl = "http://www.trazzos.com";

	$dbPrefix = "facturas_";

	$mailHost = "mail.facturase.com";
	$mailUser = "ventas@facturase.com";
	$mailPass = "Strong47";
	$mailPort = "25";

}
elseif($docRoot == "/var/www/vhosts/comprobantedigital.mx/httpdocs")
{
	$docRoot = $docRoot."/sistema";
	$webRoot = $webRoot."/sistema";

	$sqlDatabase = "pascacio_general";
	$sqlUser = "admin";
	$sqlPassword = "Strong47";
	$sqlHost = "localhost";
	
	$userPac = "SACJ840515UPA";
	$pwPac = "pfkjwdyew";

	$siteName = "BRAUN HUERIN";
	$administrationName = "TRAZZOS";
	$administrationUrl = "http://www.trazzos.com";

	$dbPrefix = "pascacio_";

	$mailHost = "mail.comprobantedigital.mx";
	$mailUser = "ventas@comprobantedigital.mx";
	$mailPass = "Strong47-";
	$mailPort = "25";

}
else
{
	$docRoot = $docRoot."/facturacion";
	$webRoot = $webRoot."/facturacion";
	
	$sqlDatabase = "facturas_general";
	$sqlUser = "root";
	$sqlPassword = "root";
	$sqlHost = "192.168.1.200";

	$userPac = "SACJ840515UPA";
	$pwPac = "pfkjwdyew";

	$siteName = "FACTURASE";
	$administrationName = "TRAZZOS";
	$administrationUrl = "http://www.trazzos.com";

	$dbPrefix = "facturas_";
	
}

define("DOC_ROOT", $docRoot);
define('WEB_ROOT', "http://".$webRoot);
	
define("SQL_HOST", $sqlHost);
define("SQL_DATABASE", $sqlDatabase);
define("SQL_USER", $sqlUser);
define("SQL_PASSWORD", $sqlPassword);

define('SMTP_HOST', $mailHost);
define('SMTP_USER', $mailUser);
define('SMTP_PASS', $mailPass);
define('SMTP_PORT', $mailPort);

?>
