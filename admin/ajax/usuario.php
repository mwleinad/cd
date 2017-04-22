<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addUsuario": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-usuario-popup.tpl');
		break;	
	case "saveAddUsuario":
	//print_r($_POST);
	
			$usuario->setUsername($_POST['username']);
			$usuario->setNombre($_POST['nombre']);
			$usuario->setPassword($_POST['password']);
			$usuario->setTipo($_POST['tipo']);
			if(!$usuario->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__usuario = $usuario->Enumerate();
				$smarty->assign("__usuario", $__usuario);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/usuario.tpl');
			}
		break;
	case "deleteUsuario":
			$usuario->setIdUsuario($_POST['idUsuario']);
			if($usuario->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$__usuario = $usuario->Enumerate();
				$smarty->assign("__usuario", $__usuario);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/usuario.tpl');
			}
		break;
	case "editUsuario": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$usuario->setIdUsuario($_POST['idUsuario']);
			$myUsuario = $usuario->Info();
			$smarty->assign("post", $myUsuario);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-usuario-popup.tpl');
		break;


		case "saveEditUsuario":
		    $usuario->setNombre($_POST['nombre']);
			$usuario->setIdUsuario($_POST['idUsuario']);
			$usuario->setUsername($_POST['username']);
			$usuario->setPassword($_POST['password']);
			$usuario->setTipo($_POST['tipo']);
			if(!$usuario->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__usuario = $usuario->Enumerate();
				$smarty->assign("__usuario", $__usuario);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/usuario.tpl');
			}
		break;
		case "adquisicion":
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$usuario->setIdUsuario($_POST['idUsuario']);
			$paquetes = $paqs ->Enumerate();
			$smarty->assign("paquetes",$paquetes);
			$myUsuario = $usuario->Info();
		//	print_r($myUsuario);exit;
			$smarty->assign("post", $myUsuario);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-adquision-popup.tpl');
		
		break;
		case "adquisicionAdd":
		
		   $compra->setPaqFoliosId($_POST['paqFoliosId']);
		   $compra->setFecha(date('Y-m-d'));
		   $compra->setUsuarioId($_POST['usuarioId']);
		   
		   if(!$compra->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__usuario = $usuario->Enumerate();
				$smarty->assign("__usuario", $__usuario);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/usuario.tpl');
			}
		   
		
		
		break;
}
?>
