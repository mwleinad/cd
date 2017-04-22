<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
//include_once(DOC_ROOT."/classes/goout.subclass.php");
//$goOut = new GoOut;
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
switch($_POST["action"])
{
	case "detalles": 
//		$user->setUserId($_POST["id"]);
		$info = $user->Info($_POST["id"]);
		$smarty->assign("vs", $info);
		$smarty->display(DOC_ROOT.'/templates/boxes/status_open.tpl');
		$smarty->display(DOC_ROOT.'/templates/items/usuario_detail_base.tpl');
		$smarty->display(DOC_ROOT.'/templates/boxes/status_close.tpl');
		break;
	case "pagar_periodo": 
		$user->setUserId($_POST["id"], 1);
		$user->setCantidadAPagar($_POST["cantidad"]);
		$pago = $user->PagarPeriodo();
		$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		echo "#|#";
		$smarty->assign("usuario", $pago);
		$empresa = $user->EmpresaInfo();
		$smarty->assign("empresa", $empresa);
		$smarty->display(DOC_ROOT.'/templates/items/status_pago_base.tpl');
		break;
	case "cancelar_pago": 
		$user->setUserId($_POST["id"], 1);
		$pago = $user->CancelarPagoPeriodo();
		
		$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		echo "#|#";
		$smarty->assign("usuario", $pago);
		$empresa = $user->EmpresaInfo();
		$smarty->assign("empresa", $empresa);
		$smarty->display(DOC_ROOT.'/templates/items/status_pago_base.tpl');
		
		break;
}
?>
