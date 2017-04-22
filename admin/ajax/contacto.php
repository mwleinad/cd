<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addContacto": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-contacto-popup.tpl');
		break;	
	case "saveAddContacto":
			$contacto->setNombre($_POST['nombre']);
			$contacto->setEmail($_POST['email']);
			$contacto->setTelefono($_POST['telefono']);
			$contacto->setTexto($_POST['texto']);
			if(!$contacto->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__contacto = $contacto->Enumerate();
				$smarty->assign("__contacto", $__contacto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/contacto.tpl');
			}
		break;
	case "deleteContacto":
			$contacto->setIdContacto($_POST['idContacto']);
			if($contacto->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$__contacto = $contacto->Enumerate();
				$smarty->assign("__contacto", $__contacto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/contacto.tpl');
			}
		break;
	case "editContacto": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$contacto->setIdContacto($_POST['idContacto']);
			$myContacto = $contacto->Info();
			$myContacto["texto"] = utf8_encode($myContacto["texto"]);
			$smarty->assign("post", $myContacto);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-contacto-popup.tpl');
		break;
	case "saveEditContacto":
			$contacto->setIdContacto($_POST['idContacto']);
			$contacto->setNombre($_POST['nombre']);
			$contacto->setEmail($_POST['email']);
			$contacto->setTelefono($_POST['telefono']);
			$contacto->setTexto($_POST['texto']);
			if(!$contacto->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__contacto = $contacto->Enumerate();
				$smarty->assign("__contacto", $__contacto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/contacto.tpl');
			}
		break;
}
?>
