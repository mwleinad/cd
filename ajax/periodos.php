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
	case "finalizar": 
		$empresa->setPeriodoId($_POST["id"]);
		if(!$empresa->FinalizarPeriodo())
		{
			echo "fail#|#";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok#|#";
			$periodos = $empresa->ListPeriodos();
			$smarty->assign("periodos", $periodos);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/lists/periodos.tpl');
		}
		
		
		break;
}
?>
