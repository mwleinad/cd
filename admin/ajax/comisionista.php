<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case 'filtrar':
					$comisionista->setTipo($_POST['tipo']);
					if(!$comisionista->FiltroTipo())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						$smarty->assign("orden", $ordenes->FiltroTipo());
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
							break;	

	
	case 'cancelarOrdenes':
	
					$comisionista->setId($_POST['id']);
					
					if(!$comisionista->CancelarOrden())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						$smarty->assign("orden", $ordenes->FiltroTipo());
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
						echo '|';
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
							break;	

					
	case 'addFolios':
						$ordenes->setId($_POST['id']);
						$smarty->assign("data", $ordenes->Data());
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/add-folios-popup.tpl');
						break;
	case 'addLog':
						$ordenes->setId($_POST['id']);
						$smarty->assign("data", $ordenes->Log());
						$smarty->assign("empresaId", $_POST['id']);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/view-log-popup.tpl');
						break;
	
	case "editComisionista": 
						$comisionista->setId($_POST['id']);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->assign("empresaId", $_POST['id']);
						
						$myUsuario = $comisionista->Info();
						//print_r($myUsuario);
						$smarty->assign("Myusuario",$myUsuario);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/edit-porcentaje-popup.tpl');
		break;
		
		
	case "showreferido": 
						$comisionista->setId($_POST['id']);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->assign("empresaId", $_POST['id']);
						
						$referido = $comisionista->showreferidos();
						//print_r($referido);
						$smarty->assign("referido",$referido);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/referido-popup.tpl');
	break;

	case 'saveAddLog':
//						print_r($_POST);
						$ordenes->setId($_POST['id']);
						$ordenes->setStatus($_POST['log']);
						if(!$ordenes->AddLog())
						{
							echo "fail|";
							$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				
						}
						else
						{
							echo "ok|";
							$smarty->assign("orden", $ordenes->FiltroTipo());
							$smarty->assign("DOC_ROOT", DOC_ROOT);
							$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
							echo '|';
							//$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
						}
					break;	

	case 'saveAddFolios':
						$ordenes->setId($_POST['id']);
						$ordenes->setStatus($_POST['status']);
						$ordenes->setCantidad($_POST['cantidad']);
						if(!$ordenes->AddFolios())
						{
							echo "fail|";
							$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				
						}
						else
						{
							echo "ok|";
							$smarty->assign("orden", $ordenes->FiltroTipo());
							$smarty->assign("DOC_ROOT", DOC_ROOT);
							$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
							echo '|';
							$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
						}
					break;
	
						
	
	case "saveEditComisionista":
			$comisionista->setId($_POST['idEmpresa']);
			$comisionista->setporcentaje($_POST['porcentaje']);
			$comisionista->setpagado($_POST['pagado']);
			$comisionista->setadeudo($_POST['adeudo']);
			
			if(!$comisionista->Edit())
			{
				echo "fail|";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok|";
				$smarty->assign("comisionista",$comisionista->OrdenesLista());
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "|";
				$smarty->display(DOC_ROOT.'/templates/lists/comisionista.tpl');
			}
		break;
						
						
}
?>