<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addConfig": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-config-popup.tpl');
		break;	
	case "saveAddConfig":
			$config->setEmail($_POST['email']);
			if(!$config->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__config = $config->Enumerate();
				$smarty->assign("__config", $__config);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/config.tpl');
			}
		break;
	case "deleteConfig":
			$config->setIdConfig($_POST['idConfig']);
			if($config->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$__config = $config->Enumerate();
				$smarty->assign("__config", $__config);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/config.tpl');
			}
		break;
	case "editConfig": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$config->setIdConfig($_POST['idConfig']);
			$myConfig = $config->Info();
			$smarty->assign("post", $myConfig);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-config-popup.tpl');
		break;
	case "saveEditConfig":
			$config->setEmail($_POST['email']);
			$config->setHome($_POST['home']);
			$config->setNosotros($_POST['nosotros']);
			$config->setIdConfig($_POST['idConfig']);
			if(!$config->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				print_r($_POST);
				$__config = $config->Enumerate();
				$smarty->assign("__config", $__config);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/config.tpl');
			}
		break;
}
?>
