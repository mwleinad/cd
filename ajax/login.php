<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

if(isset($_POST['tipoLogin']))
{
	$cliente->setRfcLogin($_POST["rfc"]);
	$cliente->setEmailLogin($_POST["email"]);
	$cliente->setPassword($_POST["password"]);
	if(!$cliente->DoLoginCliente())
	{
		echo "fail|";
		$smarty->display(DOC_ROOT.'/templates/boxes/simple_status.tpl');
	}
	else
	{
		$info = $cliente->InfoCliente2();
		echo "ok|".$info["type"];
	}
	echo "CLIENTE";
}
else
{
	$empresa->setEmailLogin($_POST["email"]);
	$empresa->setPassword($_POST["password"]);
	if(!$empresa->DoLogin())
	{
		echo "fail|";
		$smarty->display(DOC_ROOT.'/templates/boxes/simple_status.tpl');
	}
	else
	{
		$info = $user->Info();
		echo "ok|".$info["type"];
	}
	echo "NORMAL";
}
?>
