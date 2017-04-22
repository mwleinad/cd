<?php

	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');
	
	$smarty->assign("permisos",$_SESSION['permisos2']);
	$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

	switch($_POST['type']){
	
		case 'editProducto':
		
			$id_empresa = $_SESSION['empresaId'];			
			
			$smarty->assign('DOC_ROOT', DOC_ROOT);
			$producto->setProductoDelete($_POST['id_producto']);
			$infoProducto = $producto->getInfoProducto();
			$smarty->assign('info', $infoProducto);
			$smarty->display(DOC_ROOT.'/templates/boxes/editar-producto-popup.tpl');
			
			break;
			
		case 'addProducto':
			
			$id_empresa = $_SESSION['empresaId'];			
						
			$smarty->assign('DOC_ROOT', DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/agregar-producto-popup.tpl');
			
			break;	
			
		case 'saveProducto':
		
			$values = explode('&', $_POST['form']);
			foreach($values as $key => $val){
				$values[$key] = explode('=', $values[$key]);
			}
			
			$id_rfc = $rfc->getRfcActive();
			
			$producto->setRfcId($id_rfc);
			$producto->setEmpresaId($_SESSION['empresaId'],1);					
			$producto->setNoIdentificacion($values[0][1]);
			$producto->setDescripcion(urldecode($values[1][1]));
			$producto->setUnidad(urldecode($values[2][1]));
			$producto->setValorUnitario($values[3][1]);			
			$producto->setPrecioCompra($values[4][1]);
										
			if(!$producto->AddProducto()){
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');				
				echo '[#]';				
				$smarty->assign('productos', $producto->GetProductosByRfc());
				$smarty->assign('DOC_ROOT', DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/productos.tpl');				
			}//else
			break;
			
		case 'saveEditProducto': 
			$values = explode('&', $_POST['form']);
			foreach($values as $key => $val){
				$values[$key] = explode('=', $values[$key]);
			}
			
			$id_rfc = $rfc->getRfcActive();
			
			$producto->setRfcId($id_rfc);
			$producto->setEmpresaId($_SESSION['empresaId'],1);					
			$producto->setNoIdentificacion(urldecode($values[0][1]));
			$producto->setDescripcion(urldecode($values[1][1]));
			$producto->setUnidad($values[2][1]);
			$producto->setValorUnitario($values[3][1]);
			$producto->setPrecioCompra($values[4][1]);
			$producto->setProductoDelete($values[5][1]);
			
			if(!$producto->EditProducto()){
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo '[#]';
				$smarty->assign('productos', $producto->GetProductosByRfc());
				$smarty->assign('DOC_ROOT', DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/productos.tpl');
			}
			break;	
		case 'deleteProducto':
				$producto->setProductoDelete($_POST['id_producto']);				
				if($producto->DeleteProducto()){
					echo 'Ok[#]';
					$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
					echo '[#]';
					$productos = $producto->GetProductosByRfc();
			  		$smarty->assign('productos', $productos);
					$smarty->assign('DOC_ROOT', DOC_ROOT);
					$smarty->display(DOC_ROOT.'/templates/lists/productos.tpl');
				}
				break;
		
	}//switch

?>
