<?php

include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

		$db->setQuery('SELECT 
			empresaId, 
			activadoEl,
			limite,
			registerDate,
			socioId,
			vencimiento,
			telefono,
			nombrePer,
			emailPer,
			celularPer,
			moduloNomina,
			moduloImpuestos,
			moduloIsh,
			moduloAgrario,
			donatarias
		FROM empresa 
		WHERE borrar = "NO" AND activo = "1"');
		$result = $db->GetResult();
		
		//con ventas
		$sinVenta = 0;
		foreach($result as $key => $value)
		{
			//get last sale
			$db->setQuery("SELECT 
			fechaPagado
		FROM ventas  WHERE status = 'pagado' AND idEmpresa = '".$value["empresaId"]."' ORDER BY idVenta DESC LIMIT 1");
		//echo $db->query;
		$result[$key]["ultimaVentaFolios"] = $db->GetSingle();
		
		if(!$result[$key]["ultimaVentaFolios"])
		{
			$result[$key]["expiraFolios"] = date("Y-m-d", strtotime($result[$key]["registerDate"]." + 1 MONTH"));		
		}
		else
		{
			$result[$key]["expiraFolios"] = date("Y-m-d", strtotime($result[$key]["ultimaVentaFolios"]." + 1 YEAR"));		
		}
		
		if(!$result[$key]["ultimaVentaFolios"])
		{
			$sinVenta++;
		}
		//	 = date("Y-m-d", strtotime($result[$key]["ultimaVentaFolios"]." + 1 YEAR"));
			
			$db->setQuery("UPDATE empresa SET vencimiento = '".$result[$key]["expiraFolios"]."' WHERE empresaId = '".$value["empresaId"]."' LIMIT 1");
			echo "\n";
			$db->UpdateData();
		}
		//print_r($result);
		echo $sinVenta;
?>