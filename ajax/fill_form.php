<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

$info = $empresa->Info();
$smarty->assign("info", $info);

switch($_POST["type"])
{
	case "producto": 
	$producto->setNoIdentificacion($_POST["value"]);
	$result = $producto->GetProDuctoInfo();
	echo urldecode($result["descripcion"]);
	echo "{#}";
	echo number_format($result["valorUnitario"],2, ".","");
	echo "{#}";
	echo $result["unidad"];
	echo "{#}";
	echo number_format($result["precioCompra"],2, ".","");
	echo "{#}";
	break;

	case "impuesto": 
//	print_r($_POST);
	$impuesto->setImpuestoId($_POST["value"]);
	$result = $impuesto->Info();
	echo urldecode($result["nombre"]);
	echo "{#}";
	echo $result["tasa"];
	echo "{#}";
	echo $result["tipo"];
	echo "{#}";
	echo $result["iva"];
	echo "{#}";
	break;

	case "datosFacturacion": 
		$userId = $_POST["value"];
		$user->setUserId($userId, 1);
		$result = $user->GetUserInfo();
		if(!$result)
		{
			echo "{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}{#}";
			exit();
		}
		echo "{#}";
		echo "{#}";
		echo "{#}";
		echo $result["nombre"];
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
		echo " \nEMAIL: ";
		echo $result["email"];
		
		if($info["moduloEscuela"] == "Si")
		{
			echo " \nNo. Control: ";
			echo $result["noControl"];
			echo "  Carrera: ";
			echo $result["carrera"];
		}
		echo "{#}";
		echo $result["rfc"];
		echo "{#}";
		echo $result["userId"];
		echo "{#}";
		echo $result["calle"];
		echo "{#}";
		echo $result["pais"];
		echo "{#}";
		
	break;
}

?>
