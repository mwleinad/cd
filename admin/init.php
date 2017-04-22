<?php 

if (!isset($_SESSION)) 
{
  session_start();
}


ini_set("display_errors", "ON"); 
error_reporting(E_ALL ^ E_NOTICE);

date_default_timezone_set('America/Los_Angeles');

?>