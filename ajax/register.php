<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
echo DOC_ROOT;
exit();

$empresa->setEmail($_POST["email"]);
$empresa->setPassword($_POST["password"]);
$empresa->setCalle($_POST["calle"]);
$empresa->setColonia($_POST["colonia"]);
$empresa->setEstado($_POST["estado"]);
$empresa->setPais($_POST["pais"]);
$empresa->setRazonSocial($_POST["razonSocial"], 0);
$empresa->setNoInt($_POST["noInt"]);
$empresa->setNoExt($_POST["noExt"]);
$empresa->setReferencia($_POST["referencia"]);
$empresa->setLocalidad($_POST["localidad"]);
$empresa->setMunicipio($_POST["municipio"]);
$empresa->setCp($_POST["cp"]);
$empresa->setProductId($_POST["productId"]);
$empresa->setRfc($_POST["rfc"]);

//print_r($_POST["proveedorId"]);
$usuario->setEmailProveedor($_POST["proveedorId"]);
$usuarioId = $usuario->GetUsuarioIdByEmail();
															
$empresa->setProveedorId($usuarioId);
$empresa->setSocioId($_POST["socioId"]);

if(!$empresa->Register())
{
	echo "fail|";
}
else
{
	echo "ok|";
}

$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');

?>
