<?php 

if (!isset($_SESSION)){
  session_start();
}

if ( !defined( 'E_DEPRECATED' ) )		define( 'E_DEPRECATED', 8192 );

ini_set("memory_limit", "1024M"); 
ini_set("display_errors", "ON"); 

echo $version = PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;

switch($version)
{
	case "5.2": $showErrors = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT; break;
	case "5.4": $showErrors = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT; break;
//	case "5.4": $showErrors = E_ALL ^ (E_STRICT | E_NOTICE | E_DEPRECATED); break;
	default: $showErrors = E_ALL ^ (E_STRICT | E_NOTICE | E_DEPRECATED); break;
}
error_reporting($showErrors);

date_default_timezone_set('America/Mexico_City');

if(function_exists('xdebug_disable'))	
	xdebug_disable();

?>