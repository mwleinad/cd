<?php

if (!isset($_SESSION)){
  session_start();
}

include_once("../config.php");


if($_GET["id"] && $_SESSION["empresaId"] != $_GET["id"])
{
	header("Location:".WEB_ROOT."/sistema");
	exit();
}

header('Content-disposition: attachment; filename='.$_GET["filename"]);
header('Content-type: '.$_GET["contentType"]);
//$file = urldecode($_GET["path"].$_GET["secPath"]."/".$_GET["filename"]);
$file = urldecode($_GET["path"].$_GET["secPath"]."/".$_GET["filename"]);
//$path = 

//if($file
$file = str_replace(WEB_ROOT, DOC_ROOT, $file);
//echo $file;
readfile($file);

?>