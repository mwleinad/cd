<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
$result = $main->Proveedores($_POST["value"]);
if(!$result)
{
?>
	<div style="border:solid; border-width:1px; border-color:#000; background-color:#FF6; color:#666; padding:3px; width:400px">No hay Proveedores
  </div>
<?php 		
}
foreach($result as $user)
{
?>
	<div style="border:solid; border-width:1px; border-color:#000; background-color:#FF6; color:#666; padding:3px; width:400px;" id="resultSuggestUser<?php echo $user["usuarioId"] ?>" >
		<span style="width:100px; font-weight:bold; cursor:pointer" class="resultSuggestUser"><?php echo $user["email"] ?></span>
  </div>
<?php
}
?>
