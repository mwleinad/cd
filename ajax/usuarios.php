<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

switch($_POST["type"])
{	
	case "addUsuario": 
	
			$empresa->setEmpresaId($_SESSION['empresaId'],1);
			$sucursales = $empresa->ListSucursalesEmpresa();
			
			$modulos = $usuario->GetModulos();
			$tipoUsuario = $db->EnumSelect( 'usuario', 'type' );

			//tipos de regimen
			$db->setQuery("SELECT * FROM regimenEmpleado ORDER BY nombreRegimen ASC");
			$tiposRegimen = $db->GetResult();
			$smarty->assign('tiposRegimen',$tiposRegimen);

			//bancos
			$db->setQuery("SELECT * FROM banco ORDER BY nombreBanco ASC");
			$bancos = $db->GetResult();
			$smarty->assign('bancos',$bancos);

			//riesgo
			$db->setQuery("SELECT * FROM riesgo ORDER BY riesgoNombre ASC");
			$riesgos = $db->GetResult();
			$smarty->assign('riesgos',$riesgos);

			//contrato
			$db->setQuery("SELECT * FROM tipoContrato ORDER BY nombreTipoContrato ASC");
			$contratos = $db->GetResult();
			$smarty->assign('contratos',$contratos);

        //tipo jornada
        $db->setQuery("SELECT * FROM c_TipoJornada ORDER BY descripcion ASC");
        $tipoJornada = $db->GetResult();
        $smarty->assign('tipoJornada',$tipoJornada);

			//periodicidadPago
			$db->setQuery("SELECT * FROM periodicidadPago ORDER BY nombrePeriodicidadPago ASC");
			$periodicidadPagos = $db->GetResult();
			$smarty->assign('periodicidadPagos',$periodicidadPagos);

			//estado
			$db->setQuery("SELECT * FROM estado ORDER BY nombreEstado ASC");
			$estados = $db->GetResult();
			$smarty->assign('estados',$estados);

			$smarty->assign('modulos',$modulos);
			$smarty->assign('tipoUsuario', $tipoUsuario);
			$smarty->assign('sucursales', $sucursales);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/agregar-usuario-popup.tpl');
			
			break;	

	case "saveUsuario": 
			
			$tipoUsuario = $_POST['tipoUsuario'];
			
			$usuario->setEmpresaId($_SESSION["empresaId"], 1);
			
			$usuario->setNombreCompleto($_POST["nombreCompleto"]);
			$usuario->setTipo($tipoUsuario);
			if($tipoUsuario != 'empleado' && $tipoUsuario != ''){			
				$usuario->setEmailU($_POST['email'], true);
				$usuario->setPassword($_POST['password']);
			}else{
				$usuario->setEmailU($_POST['email']);
			}
			$usuario->setSucursalId($_POST['sucursalId']);
			
			if($tipoUsuario == 'empleado'){
			
				//Para Nomina
				
				$usuario->setRegistroPatronal($_POST["registroPatronal"]);
				$usuario->setNumEmpleado($_POST["numEmpleado"]);
				$usuario->setCurp($_POST["curp"]);
				$usuario->setTipoRegimen($_POST["tipoRegimen"]);
				$usuario->setNumSeguridadSocial($_POST["numSeguridadSocial"]);
				$usuario->setDepartamento($_POST["departamento"]);
				$usuario->setClabe($_POST["clabe"]);
				$usuario->setBanco($_POST["banco"]);
				$usuario->setFechaInicioRelLaboral($_POST["fechaInicioRelLaboral"]);
				$usuario->setBanco($_POST["banco"]);
				$usuario->setPuesto($_POST["puesto"]);
				$usuario->setTipoContrato($_POST["tipoContrato"]);
				$usuario->setTipoJornada($_POST["tipoJornada"]);
				$usuario->setPeriodicidadPago($_POST["periodicidadPago"]);
				$usuario->setSalarioBaseCotApor($_POST["salarioBaseCotApor"]);
				$usuario->setRiesgoPuesto($_POST["riesgoPuesto"]);
				$usuario->setSalarioDiarioIntegrado($_POST["salarioDiarioIntegrado"]);
	
				$usuario->setRfc($_POST["rfc"]);
				$usuario->setCalle($_POST["calle"]);
				$usuario->setNoExt($_POST["noExt"]);
				$usuario->setNoInt($_POST["noInt"]);
				$usuario->setColonia($_POST["colonia"]);
				$usuario->setMunicipio($_POST["municipio"]);
				$usuario->setCp($_POST["cp"]);
				$usuario->setEstado($_POST["estado"]);
				$usuario->setLocalidad($_POST["municipio"]);
				$usuario->setPais($_POST["pais"]);
				
			}//if
			
			$permisos2 = urlencode(serialize($_POST["permisos"]));
			
			$usuario->setPermisos($permisos2);
						
			if(!$usuario->AddUsuario())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->assign("empresaUsuarios", $usuario->GetUsuariosByEmpresa());
				$smarty->display(DOC_ROOT.'/templates/lists/usuarios.tpl');
			}
			
			break;	
	
	case "editUsuario":
	
			$empresa->setEmpresaId($_SESSION['empresaId'],1);
			$sucursales = $empresa->ListSucursalesEmpresa();
			$usuario->setUsuarioId($_POST['usuario']);
			$usuarioSelec = $usuario->InfoUsuario();
			
			//componer la fecha
			$usuarioSelec["fechaInicioRelLaboral"] = $util->FormatDateMysql($usuarioSelec["fechaInicioRelLaboral"]);
			
			$tipoUsuario = $db->EnumSelect( 'usuario', 'type' );
			
			$permisos = unserialize(urldecode($usuarioSelec["permisos"]));
			$nuevosPermisos = unserialize(urldecode($usuarioSelec["nuevosPermisos"]));
			
			$modulos = $usuario->GetModulos();
		
			//tipos de regimen
			$db->setQuery("SELECT * FROM regimenEmpleado ORDER BY nombreRegimen ASC");
			$tiposRegimen = $db->GetResult();
			$smarty->assign('tiposRegimen',$tiposRegimen);

			//bancos
			$db->setQuery("SELECT * FROM banco ORDER BY nombreBanco ASC");
			$bancos = $db->GetResult();
			$smarty->assign('bancos',$bancos);

			//riesgo
			$db->setQuery("SELECT * FROM riesgo ORDER BY riesgoNombre ASC");
			$riesgos = $db->GetResult();
			$smarty->assign('riesgos',$riesgos);

			//contrato
			$db->setQuery("SELECT * FROM tipoContrato ORDER BY nombreTipoContrato ASC");
			$contratos = $db->GetResult();
			$smarty->assign('contratos',$contratos);

        //tipo jornada
        $db->setQuery("SELECT * FROM c_TipoJornada ORDER BY descripcion ASC");
        $tipoJornada = $db->GetResult();
        $smarty->assign('tipoJornada',$tipoJornada);

			//periodicidadPago
			$db->setQuery("SELECT * FROM periodicidadPago ORDER BY nombrePeriodicidadPago ASC");
			$periodicidadPagos = $db->GetResult();
			$smarty->assign('periodicidadPagos',$periodicidadPagos);

			//estado
			$db->setQuery("SELECT * FROM estado ORDER BY nombreEstado ASC");
			$estados = $db->GetResult();
			$smarty->assign('estados',$estados);

			$smarty->assign("modulos",$modulos);
			$smarty->assign("permisos",$permisos);
			$smarty->assign("nuevosPermisos",$nuevosPermisos);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->assign('tipoUsuario', $tipoUsuario);
			$smarty->assign('sucursales', $sucursales);
			$smarty->assign("post", $usuarioSelec);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-usuario-popup.tpl');
			
			break;
		
	case "saveEditUsuario": 
			
			$tipoUsuario = $_POST['tipoUsuario'];
			
			$usuario->setUsuarioId($_POST['usuarioId']);			
			$usuario->setEmpresaId($_SESSION["empresaId"], 1);
			
			$usuario->setNombreCompleto($_POST["nombreCompleto"]);
			$usuario->setTipo($tipoUsuario);
			if($tipoUsuario != 'empleado' && $tipoUsuario != ''){			
				$usuario->setEmailEdition($_POST['email'], true);
				$usuario->setPassword($_POST['password']);
			}else{
				$usuario->setEmailEdition($_POST['email']);
			}
			$usuario->setSucursalId($_POST['sucursalId']);
			
			if($tipoUsuario == 'empleado'){
			
				//Para Nomina
				
				$usuario->setRegistroPatronal($_POST["registroPatronal"]);
				$usuario->setNumEmpleado($_POST["numEmpleado"]);
				$usuario->setCurp($_POST["curp"]);
				$usuario->setTipoRegimen($_POST["tipoRegimen"]);
				$usuario->setNumSeguridadSocial($_POST["numSeguridadSocial"]);
				$usuario->setDepartamento($_POST["departamento"]);
				$usuario->setClabe($_POST["clabe"]);
				$usuario->setBanco($_POST["banco"]);
				$usuario->setFechaInicioRelLaboral($_POST["fechaInicioRelLaboral"]);
				$usuario->setBanco($_POST["banco"]);
				$usuario->setPuesto($_POST["puesto"]);
				$usuario->setTipoContrato($_POST["tipoContrato"]);
				$usuario->setTipoJornada($_POST["tipoJornada"]);
				$usuario->setPeriodicidadPago($_POST["periodicidadPago"]);
				$usuario->setSalarioBaseCotApor($_POST["salarioBaseCotApor"]);
				$usuario->setRiesgoPuesto($_POST["riesgoPuesto"]);
				$usuario->setSalarioDiarioIntegrado($_POST["salarioDiarioIntegrado"]);
	
				$usuario->setRfc($_POST["rfc"]);
				$usuario->setCalle($_POST["calle"]);
				$usuario->setNoExt($_POST["noExt"]);
				$usuario->setNoInt($_POST["noInt"]);
				$usuario->setColonia($_POST["colonia"]);
				$usuario->setMunicipio($_POST["municipio"]);
				$usuario->setCp($_POST["cp"]);
				$usuario->setEstado($_POST["estado"]);
				$usuario->setLocalidad($_POST["municipio"]);
				$usuario->setPais($_POST["pais"]);
				
			}//if			
			
			$modulos = $usuario->GetModulos();
			foreach($modulos as $key => $modulo)
			{
				$nuevosPermisos[$key] = $_POST["row_".$key];
			}
			
			$permisos2 = urlencode(serialize($_POST["permisos"]));
			$permisos3 = urlencode(serialize($nuevosPermisos));
			
			$usuario->setPermisos($permisos2);
			$usuario->setNuevosPermisos($permisos3);
			
			if(!$usuario->EditUsuario())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->assign("empresaUsuarios", $usuario->GetUsuariosByEmpresa());
				$smarty->display(DOC_ROOT.'/templates/lists/usuarios.tpl');
			}
			
			break;
	
	case "deleteUsuario":
	
			$usuario->setUsuarioDelete($_POST['usuario']);
			$usuario->setEmpresaId($_SESSION["empresaId"], 1);
			if($usuario->DeleteUsuario())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->assign("empresaUsuarios", $usuario->GetUsuariosByEmpresa());
				$smarty->display(DOC_ROOT.'/templates/lists/usuarios.tpl');
			}
			else
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
			}
			break;
		
		
}

?>
