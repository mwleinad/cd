<?php
$user->AuthAdmin();

switch($_GET["section"])
{
	case "periodos":
		switch($_GET["option"])
		{
			default: 		
				$periodos = $empresa->ListPeriodos();
				$smarty->assign("periodos", $periodos);
				break;
		}
		break;
	case "usuarios":
		switch($_GET["option"])
		{
			default: 	
				$usuarios = new User;
				$empresa = $usuarios->EmpresaInfo();
				$list = $usuarios->ListUsuarios();
				$smarty->assign("usuarios", $list);
				$smarty->assign("empresa", $empresa);
				break;
		}
		break;
	case "reportegeneral":
		switch($_GET["option"])
		{
			default: 	
				$reporte = $empresa->ReporteGeneral();
				$smarty->assign("reporte", $reporte);
				break;
		}

}
?>