<?php 

	require_once('config.php');
	require_once('init.php');
	require_once('libraries.php');
	
	require 'slim/Slim/Slim.php';
	\Slim\Slim::registerAutoloader();
	
	session_start();
		
	$app = new \Slim\Slim();
	
	$app->get('/', function () { //as closure
		echo 'Hello Worlds';
	});
		
	$app->post('/facturas', 'AccionesFactura');
	
	function AccionesFactura(){
		
		global $app;
	
		$request = $app::getInstance()->request();
		$datos = json_decode($request->getBody());

		switch($datos->accion){
			
			case 'agregarFactura':					
					AgregarFactura($datos);					
				break;
			
			case 'listarFacturas':					
					ListarFacturas($datos);				
				break;
			
			case 'verFactura':
					VerFactura($datos);
				break;
			
			case 'cancelarFactura':
					CancelarFactura($datos);
				break;
			
		}//switch
		
	}//function AccionesFactura
	
	function DoLogin($usrEmail, $passwd){
		
		global $util;
		
		//Checamos si existe el usuario
		$sql = 'SELECT empresaId FROM usuario 
				WHERE email = "'.$usrEmail.'"
				AND MD5(password) = "'.md5($passwd).'"';
		$util->DBSelect('general')->setQuery($sql);
		$empresaId = $util->DBSelect('general')->GetSingle();

		if($empresaId){
		
			//Checamos la version
			$sql = 'SELECT version FROM empresa
					WHERE empresaId = "'.$empresaId.'"';
			$util->DBSelect('general')->setQuery($sql);
			$_SESSION['version'] = $util->DBSelect('general')->GetSingle();
			
			$_SESSION['empresaId'] = $empresaId;
			
			return true;
			
		}else{
			return false;
		}
		
	}
	
	function AgregarFactura($dato){
		
		global $util;
		global $vistaPrevia;
		global $comprobante;
		
		if(!DoLogin($dato->usrEmail, $dato->passwd)){
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'Usuario y/o contrasena incorrectos.';
			echo json_encode($arrJSON);	
			exit;
		}
						
		$data['empresaId'] = $dato->empresaId;
		$data['rfcReceptor'] = $dato->rfcReceptor;		
		$data['formaDePago'] = $dato->formaDePago;
		$data['metodoDePago'] = $dato->metodoDePago;
		$data['NumCtaPago'] = $dato->NumCtaPago;
		$data['condicionesDePago'] = $dato->condicionesDePago;		
		$data['tipoComprobante'] = $dato->tipoComprobante;
		$data['sucursal'] = $dato->sucursal;
		$data['serie'] = $dato->serie;
		$data['observaciones'] = $dato->observaciones;
		$data['tasaIva'] = $dato->tasaIva;
		$data['tiposDeMoneda'] = $dato->tiposDeMoneda;
		$data['tiposDeCambio'] = $dato->tiposDeCambio;
		$data['porcentajeDescuento'] = $dato->porcentajeDescuento;
		$data['porcentajeRetIva'] = $dato->porcentajeRetIva;
		$data['porcentajeRetIsr'] = $dato->porcentajeRetIsr;
		$data['porcentajeRetIEPS'] = $dato->porcentajeRetIEPS;
					
		/*
		$data['empresaId'] = 15;						//Obligatorio X
		$data['rfcReceptor'] = 'LOAD850511SX3';			//Obligatorio X		
		$data['formaDePago'] = 'Una Sola Exhibicion';	//Obligatorio X
		$data['metodoDePago'] = 'No Identificado';		//Obligatorio X
		$data['NumCtaPago'] = 'No Identificado';		//Opcional
		$data['condicionesDePago'] = "Cheque";			//Opcional
		
		$data['tipoComprobante'] = 'Factura';			//Obligatorio X
		$data["sucursal"] = 'Matriz';					//Obligatorio X
		$data['serie'] = 'NORTE';						//Obligatorio X
		$data['observaciones']  = 'Mis observaciones';	//Opcional
		$data['tasaIva'] = '16';						//Obligatorio
		$data['tiposDeMoneda'] = 'MXN';					//Obligatorio
		$data['tiposDeCambio'] = '1';					//Obligatorio Y
		$data['porcentajeDescuento'] = "5";				//Obligatorio Y
		$data['porcentajeRetIva'] = "0";				//Obligatorio
		$data['porcentajeRetIsr'] = "0";				//Obligatorio
		$data['porcentajeRetIEPS'] = "0";				//Obligatorio Y
		*/
						
		$_SESSION['conceptos'] = array();
		
		$card = array();
		foreach($dato->conceptos as $k => $item){
			
			$card['cantidad'] = $item->cantidad;
			$card['unidad'] = $item->unidad;
			$card['noIdentificacion'] = $item->noIdentificacion;
			$card['descripcion'] = $item->descripcion;
			$card['valorUnitario'] = $item->valorUnitario;
			$card['importe'] = $item->importe;
			
			$_SESSION['conceptos'][] = $card;
			
		}//foreach
		
		/*
		$_SESSION['conceptos'][0]['cantidad'] = 1;
		$_SESSION['conceptos'][0]['unidad'] = 'Pza.';
		$_SESSION['conceptos'][0]['noIdentificacion'] = 'NA';
		$_SESSION['conceptos'][0]['descripcion'] = 'Sistema de Facturacion en Linea.';
		$_SESSION['conceptos'][0]['valorUnitario'] = 100;
		$_SESSION['conceptos'][0]['importe'] = 100;
		
		$_SESSION['conceptos'][1]['cantidad'] = 2;
		$_SESSION['conceptos'][1]['unidad'] = 'Pza.';
		$_SESSION['conceptos'][1]['noIdentificacion'] = 'NA';
		$_SESSION['conceptos'][1]['descripcion'] = 'Sistema de Facturacion en Linea.';
		$_SESSION['conceptos'][1]['valorUnitario'] = 100;
		$_SESSION['conceptos'][1]['importe'] = 200;
		*/
		
		if($dato->tipo == 'F')
			$msgRet = $comprobante->Generar($data);
		else
			$msgRet = $vistaPrevia->VistaPreviaComprobante($data);		

		if(isset($msgRet['error'])){
		
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = $msgRet['error'];
			
		}elseif(isset($msgRet['ok'])){
		
			if($dato->tipo == 'F'){
				$arrJSON['tipo'] = 'Factura';
				$arrJSON['serie'] = $msgRet['serie'];
				$arrJSON['folio'] = $msgRet['folio'];				
			}else{
				$arrJSON['tipo'] = 'VistaPrevia';
				$arrJSON['url'] = WEB_ROOT.'/pdf/vistaPrevia.pdf';
			}
						
		}
		
		echo json_encode($arrJSON);	
		
	}//AgregarFactura
	
	
	function CancelarFactura($dato){
		
		global $util;
		global $comprobante;
		
		if(!DoLogin($dato->usrEmail, $dato->passwd)){
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'Usuario y/o contrasena incorrectos.';
			echo json_encode($arrJSON);	
			exit;
		}
		
		$empresaId = $_SESSION['empresaId'];
		
		$sql = 'SELECT comprobanteId FROM comprobante 
				WHERE empresaId = "'.$empresaId.'"
				AND serie = "'.$dato->serie.'"
				AND folio = "'.$dato->folio.'"';
		$util->DBSelect($empresaId)->setQuery($sql);
		$comprobanteId = $util->DBSelect($empresaId)->GetSingle();
		
		if($comprobanteId){
			
			$sql = 'SELECT status FROM comprobante 
					WHERE comprobanteId = "'.$comprobanteId.'"';
			$util->DBSelect($empresaId)->setQuery($sql);
			$status = $util->DBSelect($empresaId)->GetSingle();
			
			if($status == 0){
				$arrJSON['tipo'] = 'Fail';
				$arrJSON['msg'] = 'La factura ya fue cancelada anteriormente.';
				echo json_encode($arrJSON);
				return;
			}
			
			if(trim($dato->motivoCancelacion) == ''){
				$arrJSON['tipo'] = 'Fail';
				$arrJSON['msg'] = 'Ingrese el motivo de la cancelacion';
				echo json_encode($arrJSON);
				return;
			}
			
			$msgRet = $comprobante->Cancelar($comprobanteId);

			if($msgRet['tipo'] == 'Ok'){
			$sql = 'UPDATE comprobante SET motivoCancelacion = ""
					WHERE comprobanteId = "'.$comprobanteId.'"
					AND empresaId = "'.$empresaId.'"';
			$util->DBSelect($empresaId)->setQuery($sql);
			$util->DBSelect($empresaId)->UpdateData();
			
				$arrJSON['tipo'] = 'Ok';
				$arrJSON['msg'] = 'Factura cancelada correctamente.';
			}else{
				$arrJSON['tipo'] = 'Fail';
				$arrJSON['msg'] = 'Error al cancelar la Factura';
			}	
			echo json_encode($arrJSON);
			
		}else{		
			
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'No se encontro la factura.';			
			echo json_encode($arrJSON);
			
		}
					
	}//CancelarFactura
	
	function ListarFacturas($dato){
		
		global $util;

		if(!DoLogin($dato->usrEmail, $dato->passwd)){
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'Usuario y/o contrasena incorrectos.';
			echo json_encode($arrJSON);	
			exit;
		}
		
		$empresaId = $_SESSION['empresaId'];
				
		$sql = 'SELECT * FROM comprobante 
				WHERE empresaId = "'.$empresaId.'"';	
		$util->DBSelect($empresaId)->setQuery($sql);
		$result = $util->DBSelect($empresaId)->GetResult();
		
		$facturas = array();
		foreach($result as $res){
			
			unset($res['data']);
			
			$nomFile = $infC['empresaId'].'_'.$infC['serie'].'_'.$infC['folio'];
			$res['pdf'] = WEB_ROOT.'/empresas/'.$infC['empresaId'].'/certificados/1/facturas/pdf/'.$nomFile.'.pdf';
			
			$nomXml = $infC['empresaId'].'_'.$infC['serie'].'_'.$infC['folio'];
			$res['xml'] = WEB_ROOT.'/empresas/'.$infC['empresaId'].'/certificados/1/facturas/xml/'.$nomFile.'.xml';
			
			$facturas[] = $res;
		}
		
		echo '{"facturas": ' . json_encode($result) . '}';
		
	}//ListarFacturas
	
	function VerFactura($dato){
		
		global $util;
		
		if(!DoLogin($dato->usrEmail, $dato->passwd)){
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'Usuario y/o contrasena incorrectos.';
			echo json_encode($arrJSON);	
			exit;
		}
		
		$empresaId = $_SESSION['empresaId'];
				
		$sql = 'SELECT * FROM comprobante 
				WHERE empresaId = "'.$empresaId.'"
				AND serie = "'.$dato->serie.'"
				AND folio = "'.$dato->folio.'"';
		$util->DBSelect($empresaId)->setQuery($sql);
		$infC = $util->DBSelect($empresaId)->GetRow();
		
		if($infC['comprobanteId']){
			
			unset($infC['data']);
			
			$nomFile = $infC['empresaId'].'_'.$infC['serie'].'_'.$infC['folio'];
			$infC['pdf'] = WEB_ROOT.'/empresas/'.$infC['empresaId'].'/certificados/1/facturas/pdf/'.$nomFile.'.pdf';
			
			$nomXml = $infC['empresaId'].'_'.$infC['serie'].'_'.$infC['folio'];
			$infC['xml'] = WEB_ROOT.'/empresas/'.$infC['empresaId'].'/certificados/1/facturas/xml/'.$nomFile.'.xml';
						
			echo json_encode($infC);	
					
		}else{		
		
			$arrJSON['tipo'] = 'Fail';
			$arrJSON['msg'] = 'No se encontro la factura.';			
			echo json_encode($arrJSON);
			
		}
		
	}//VerFactura
		
	$app->run();

?>