<?php 

if (!isset($_SESSION)) {
  session_start();
}

ini_set("display_errors", "ON"); 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);

date_default_timezone_set('America/Mexico_City');


if (function_exists('xdebug_disable'))
	xdebug_disable();

?>