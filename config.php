<?php

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot = $_SERVER['HTTP_HOST'];

$docRoot = $docRoot."/sistema";
$webRoot = $webRoot."/sistema";

$sqlDatabase = "pascacio_general";
$sqlUser = "root";
$sqlPassword = "d?8djzdTE%gg9E2P";
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


define("DOC_ROOT", $docRoot);
define('WEB_ROOT', "https://".$webRoot);
	
define("SQL_HOST", $sqlHost);
define("SQL_DATABASE", $sqlDatabase);
define("SQL_USER", $sqlUser);
define("SQL_PASSWORD", $sqlPassword);

define('SMTP_HOST', $mailHost);
define('SMTP_USER', $mailUser);
define('SMTP_PASS', $mailPass);
define('SMTP_PORT', $mailPort);

?>
