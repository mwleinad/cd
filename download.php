<?php

if (!isset($_SESSION)){
  session_start();
}

if($_GET["id"] && $_SESSION["empresaId"] != $_GET["id"])
{
	header("Location:sistema");
	exit();
}

header('Content-disposition: attachment; filename='.$_GET["file"]);
header('Content-type: application/octet-stream');
readfile(urldecode($_GET["file"]));
?>