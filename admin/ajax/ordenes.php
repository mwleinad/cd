<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();

switch($_POST["type"])
{


    case 'filtro_busqueda':
	
	     echo "ok|";
						
						//print_r($_POST);exit;
						$ordenes->setMes($_POST['mes']);
						$ordenes->setVencimiento($_POST['vencimiento']);
						if($_SESSION['tipo'] == "admin")
						{
							$ordenes->setSocioId($_POST['socioId']);
							$ordenes->setVersion($_POST['version']);
						}
						$usuario->AuthAdmin();
						$borrar = 'No';
						if($_POST['inactivos']) {
						    $borrar = 'Si';
                        }
						$ordenes = $ordenes->OrdenesLista($borrar);
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						
						$usuario->setIdUsuario($_SESSION['loginKey']);
						$__usuario = $usuario->EnumerateUsuario();
						
						//print_r($__usuario);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("info",$__usuario);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
	   
	break;
	
	case 'changePrice':
		$ordenes -> setEmpresaId($_POST['empresaId']);
						$infoEmpresa = $ordenes->InfoEmpresa();
						
						$smarty->assign("info",$infoEmpresa);
						$smarty->assign("empresaId", $_POST['empresaId']);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/edit-price-popup.tpl');
	
	break;
    case 'changeSocio':
	
	    // PRINT_r($_POST); exit;
						$ordenes -> setEmpresaId($_POST['empresaId']);
						$infoEmpresa = $ordenes->InfoEmpresa();
						$listUsuarios = $usuario->Enumerate();
						$smarty->assign("infoEmpresa",$infoEmpresa);
						$smarty->assign("listUsuarios",$listUsuarios);
						$smarty->assign("empresaId", $_POST['empresaId']);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT.'/templates/boxes/edit-socio-popup.tpl');
	
	
	break;
	
	case 'changePriceSave':
	
	        $usuario->setEmpresaId($_POST['empresaId']);
					$usuario->setIdUsuario($_POST['socioId']);
					$usuario->setPrecio($_POST['precio']);
					$usuario->setModuloNomina($_POST['moduloNomina']);
					$usuario->setModuloImpuestos($_POST['moduloImpuestos']);
					$usuario->setCostoModuloImpuestos($_POST['costoModuloImpuestos']);
					$usuario->setCostoModuloNomina($_POST['costoModuloNomina']);
					$usuario->setPrecioCliente($_POST['precioCliente']);
					if(!$usuario->SaveChangePrice())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						
						$usuario->AuthAdmin();
						$ordenes = $ordenes->OrdenesLista();
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						//print_r($data);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
	
	
	break;
	
	case 'borrarEmpresa':
	
	        $ordenes->setId($_POST['empresaId']);
					if(!$ordenes->BorrarEmpresa())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						
						$usuario->AuthAdmin();
						$ordenes = $ordenes->OrdenesLista();
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						//print_r($data);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
	
	
	break;

	case 'changeActivo':
	
	        $ordenes->setId($_POST['empresaId']);
					if(!$ordenes->CambiarEstatus())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						
						$usuario->AuthAdmin();
						$ordenes = $ordenes->OrdenesLista();
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						//print_r($data);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
	
	
	break;
	
	case 'toggleInterno':
	
	        $ordenes->setId($_POST['empresaId']);
					if(!$ordenes->CambiarInterno())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						
						$usuario->AuthAdmin();
						$ordenes = $ordenes->OrdenesLista();
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						//print_r($data);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
	
	
	break;	
	
	case 'changeSocioSave':
	
					$usuario->setEmpresaId($_POST['empresaId']);
					$usuario->setIdUsuario($_POST['socioId']);
					if(!$usuario->SaveChangeSocio())
					{
						echo "fail|";
						$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			
					}
					else
					{
						echo "ok|";
						
						$usuario->AuthAdmin();
						$ordenes = $ordenes->OrdenesLista();
						$data = array();
						foreach($ordenes as $orden)
						{
							$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
						}
						//print_r($data);
						$smarty->assign("roleId",$_SESSION['roleId']);
						$smarty->assign('data', $data);
						$smarty->assign('orden', $ordenes);
						$smarty->assign("DOC_ROOT", DOC_ROOT);
						$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
					}
	    
	break;
	case 'filtrar':
					$ordenes->setTipo($_POST['tipo']);
					if(!$ordenes->FiltroTipo())
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
	
					$ordenes->setId($_POST['id']);
					if(!$ordenes->CancelarOrden())
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
							$smarty->assign("roleId",$_SESSION['Usr']['roleId']);
							$smarty->assign("orden", $ordenes->FiltroTipo());
							$smarty->assign("DOC_ROOT", DOC_ROOT);
							$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
							echo '|';
							$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
						}
								break;	
	
	case 'editFechaVenc':
			
			$ordenes -> setEmpresaId($_POST['empresaId']);
			$infoEmpresa = $ordenes->InfoEmpresa();
						
			$smarty->assign("info",$infoEmpresa);						
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-fecha-venc-popup.tpl');
						
		break;
		
	case 'saveFechaVenc':
			
			$usuario->setEmpresaId($_POST['empresaId']);
			$usuario->setFechaVenc($_POST['fechaVenc']);
			$usuario->setLimiteFolios($_POST['limiteFolios']);
		
			if(!$usuario->SaveFechaVenc()){
				echo "fail|";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{
				
				$usuario->AuthAdmin();
				$ordenes = $ordenes->OrdenesLista();
				$data = array();
				foreach($ordenes as $orden)
				{
					$data["countRazonSocial"][$orden["socio"]["razonSocial"]]++; 
				}
				
				echo 'ok[#]';
				
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				
				echo '[#]';
				
				$smarty->assign("roleId",$_SESSION['roleId']);
				$smarty->assign('data', $data);
				$smarty->assign('orden', $ordenes);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT."/templates/lists/ordenes.tpl");
			
			}
			
		break;
						
}

?>