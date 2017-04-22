<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$usuario->setUsername($_POST["username"]);
$usuario->setPassword($_POST["password"]);
if(!$usuario->DoLogin())
{
	echo "fail|";
	$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
}
else
{
	$info = $usuario->Info();
	echo "ok|".$info["tipo"];
}

?>
