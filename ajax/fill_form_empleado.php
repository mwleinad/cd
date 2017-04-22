<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
switch($_POST["type"])
{
	case "datosFacturacion": 
		$userId = $_POST["value"];
		$usuario->setUsuarioId($userId);
		$result = $usuario->InfoUsuario();
		print_r($result);
		if(!$result)
		{
			echo "{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}";
			exit();
		}
		echo "{#}";
		echo "{#}";
		echo "{#}";
		echo $result["nombreCompleto"];
		echo "\nDIRECCION: ";
		echo $result["calle"];
		echo " ";
		echo $result["noExt"];
		echo " ";
		echo $result["noInt"];
		echo " ";
		echo $result["colonia"];
		echo " ";
		echo $result["municipio"];
		echo " ";
		echo $result["estado"];
		echo " ";
		echo $result["localidad"];
		echo " ";
		echo $result["referencia"];
		echo " ";
		echo $result["pais"];
		echo " CP: ";
		echo $result["cp"];
		echo " \nCURP: ";
		echo $result["curp"];
		echo " #Empleado:";
		echo $result["numEmpleado"];
		echo " Sueldo Base: $";
		echo $result["salarioBaseCotApor"];
		echo "{#}";
		echo $result["rfc"];
		echo "{#}";
		echo $result["usuarioId"];
		echo "{#}";
		echo $result["calle"];
		echo "{#}";
		echo $result["pais"];
		echo "{#}";
		
	break;
}

?>
