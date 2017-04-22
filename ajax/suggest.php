<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$user->setEmpresaId($_SESSION["empresaId"], 1);
$user->setRfcId($user->getRfcActive());
$result = $user->Suggest($_POST["value"]);

$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

if(!$result)
{
?>
	<div style="border:solid; border-width:1px; border-color:#000; background-color:#FF6; color:#666; padding:3px; width:400px">No existen Clientes, <a href="<?php echo WEB_ROOT?>/cliente">Agregar nuevo Cliente?</a>
  </div>
<?php 		
}

foreach($result as $user)
{
?>
	<div class="suggestUserDiv" style="border:solid; border-width:1px; border-color:#000; background-color:#FFFFE6; color:#333; padding:3px; width:530px;" id="<?php echo $user["rfc"] ?>" >
		<div class="suggestUserDiv" id="<?php echo $user["userId"] ?>" style="float:left;width:60px; font-weight:bold; cursor:pointer"><?php echo $user["userId"] ?></div>
		<div class="suggestUserDiv" id="<?php echo $user["userId"] ?>" style="float:left;width:150px; cursor:pointer"><?php echo $user["rfc"] ?></div>
		<div class="suggestUserDiv" id="<?php echo $user["userId"] ?>" style="float:left;width:300px; cursor:pointer"><?php echo $user["nombre"] ?></div>
		<div class="closeSuggestUserDiv" style="float:left;width:20px; cursor:pointer">X</div>
    <div style="clear:both"></div>
  </div>
<?php
}
?>
