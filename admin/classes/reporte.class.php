<?php 

class Reporte extends Main
{
	private $idReporte;
	private $date;
	private $data;

	public function setIdReporte($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idReporte = $value;
	}

	public function getIdReporte()
	{
		return $this->idReporte;
	}

	public function setDate($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'date');
		$this->date = $value;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function setData($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'data');
		$this->data = $value;
	}

	public function getData()
	{
		return $this->data;
	}

	public function Enumerate()
	{
		$this->Util()->DB()->setQuery('SELECT COUNT(*) FROM reporte');
		$total = $this->Util()->DB()->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/reporte");

		$sql_add = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		$this->Util()->DB()->setQuery('SELECT * FROM reporte ORDER BY idReporte ASC '.$sql_add);
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row)
		{
		}
		$data["items"] = $result;
		$data["pages"] = $pages;
		return $data;
	}

	public function Info()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM reporte WHERE idReporte = '".$this->idReporte."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				reporte
			SET
				`idReporte` = '".$this->idReporte."',
				`date` = '".$this->date."',
				`data` = '".$this->data."'
			WHERE idReporte = '".$this->idReporte."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				reporte
			(
				`idReporte`,
				`date`,
				`data`
		)
		VALUES
		(
				'".$this->idReporte."',
				'".$this->date."',
				'".$this->data."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				reporte
			WHERE
				idReporte = '".$this->idReporte."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(1, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	function GenerateReporteGeneral()
	{
		echo "<pre>";
		$preciosFolios = array(
			50 => 8,											 
			100 => 8,											 
			150 => 5.33,											 
			300 => 4.67,											 
			500 => 4.20,											 
			1000 => 3.90,											 
			1500 => 3.67,											 
			2000 => 3.35,											 
			3000 => 2.80											 
		);
		
		$pagoEdicom = 0.46;
		$porcentajeVendio = 0.8;
		$porcentajeSobrante = 0.2;
		$porcentajeComision = 0.4;
		$iva = 0.16;
		$precioPaquete = 2500;
		
		$month = $_GET["month"];
		$year = $_GET["year"];

		$this->Util()->DB()->setQuery("SELECT * FROM empresa 
				LEFT JOIN socio ON socio.socioId = empresa.socioId
				ORDER BY empresaId DESC");
		$result = $this->Util()->DB()->GetResult();


		$data["facturasExpedidas"] = 0;
		foreach($result as $key => $empresa)
		{
			//facturas expedidas
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM facturas_".$empresa["empresaId"].".comprobante WHERE MONTH(fecha) = '".$month."' AND YEAR(fecha) = '".$year."' LIMIT 1");			
			$data["facturasExpedidas"] += $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();
		}
		
		$this->Util()->DB()->setQuery("SELECT * FROM empresa 
				LEFT JOIN socio ON socio.socioId = empresa.socioId
				WHERE MONTH(empresa.activadoEl) = '".$month."'
				ORDER BY empresaId DESC");
		$result = $this->Util()->DB()->GetResult();
		
		$data["nuevosPaquetes"] = 0;
		$data["nuevosPaquetesTrazzos"] = 0;
		$data["nuevosPaquetesAvantika"] = 0;
		$data["nuevosFolios"] = 0;
		$data["ventasFolios"] = 0;
		$data["ventasFoliosIVA"] = 0;
		$data["ventasFoliosIvaIncluido"] = 0;
		$data["pagoEdicom"] = 0;
		$data["pagoEdicomAvantika"] = 0;
		$data["pagoEdicomTrazzos"] = 0;
		
		$data["ventasFoliosDespuesPagoEdicom"] = 0;
		$data["gananciasFoliosAvantika"] = 0;
		$data["gananciasFoliosTrazzos"] = 0;
		$data["totalPagos"] = 0;
		
		
		$data["totalVentasPaquete"] = 0;
		$data["totalVentasPaqueteIVA"] = 0;
		$data["totalVentasPaqueteIvaIncluido"] = 0;
		$data["totalVentasPaqueteTrazzos"] = 0;
		$data["totalVentasPaqueteIVATrazzos"] = 0;
		$data["totalVentasPaqueteIvaIncluidoTrazzos"] = 0;
		$data["totalVentasPaqueteAvantika"] = 0;
		$data["totalVentasPaqueteIVAAvantika"] = 0;
		$data["totalVentasPaqueteIvaIncluidoAvantika"] = 0;
		
		$data["comisionesPeriodo"] = 0;
		$data["comisionesPeriodoIVA"] = 0;
		$data["comisionesPeriodoTotal"] = 0;
		
		$data["devolucionTrazzosIVAIncluido"] = 0;
		$data["devolucionTrazzosIVA"] = 0;
		$data["devolucionTrazzos"] = 0;

		$data["devolucionTrazzosMasFolios"] = 0;

		$data["trazzosCompensacion"] = 0;
		$data["trazzosFacturaDe"] = 0;
		
		foreach($result as $key => $empresa)
		{
			$data["nuevosPaquetes"]++;
			$data["totalVentasPaquete"] += $precioPaquete;
			$data["totalVentasPaqueteIVA"] += $precioPaquete * $iva;
			$data["totalVentasPaqueteIvaIncluido"] += $data["totalVentasPaquete"] * $data["totalVentasPaqueteIVA"];

			if($empresa["socioId"] == 5)
			{
				$data["nuevosPaquetesAvantika"]++;

				$data["totalVentasPaqueteAvantika"] += $precioPaquete;
				$data["totalVentasPaqueteIVAAvantika"] += $precioPaquete * $iva;
				$data["totalVentasPaqueteIvaIncluidoAvantika"] += $data["totalVentasPaqueteAvantika"] + $data["totalVentasPaqueteIVAAvantika"];
				
				$data["comisionesPeriodo"] = $data["totalVentasPaqueteAvantika"] * $porcentajeComision;
				$data["comisionesPeriodoIVA"] = $data["comisionesPeriodo"] / (1 + $iva);
				$data["comisionesPeriodoTotal"] = $data["comisionesPeriodo"] - $data["comisionesPeriodoIVA"];
				
				$data["devolucionTrazzosIVAIncluido"] = $data["totalVentasPaqueteIvaIncluidoAvantika"] - $data["comisionesPeriodo"];
				$data["devolucionTrazzosIVA"] = $data["devolucionTrazzosIVAIncluido"] - ($data["devolucionTrazzosIVAIncluido"] / (1 + $iva));
				$data["devolucionTrazzos"] = $data["devolucionTrazzosIVAIncluido"] - $data["devolucionTrazzosIVA"];
				
			}
			else
			{
				$data["nuevosPaquetesTrazzos"]++;
				$data["totalVentasPaqueteTrazzos"] += $precioPaquete;
				$data["totalVentasPaqueteIVATrazzos"] += $precioPaquete * $iva;
				$data["totalVentasPaqueteIvaIncluidoTrazzos"] += $data["totalVentasPaqueteTrazzos"] + $data["totalVentasPaqueteIVATrazzos"];
			}
			
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT * FROM facturas_".$empresa["empresaId"].".rfc LIMIT 1");
			$result[$key]["rfc"] = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			$data["cliente"][] = $result[$key];
			
			$result[$key]["rfc"] = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			
			$result[$key]["rfc"]["razonSocial"] = urldecode($result[$key]["rfc"]["razonSocial"]);
			
			switch($result[$key]["version"])
			{
				case 2: $result[$key]["version"] = "Medios Propios";break;
				case "v3": $result[$key]["version"] = "PAC";break;
				case "auto": $result[$key]["version"] = "AutoImpreso";break;
				case "ticgums": $result[$key]["version"] = "Medios Propios";break;
				case "avantika": $result[$key]["version"] = "Medios Propios";break;
				case "construc": $result[$key]["version"] = "PAC";break;
				case "demo": $result[$key]["version"] = "PAC";break;
				case "global": $result[$key]["version"] = "PAC";break;
			}

			$this->Util()->DB()->setQuery("SELECT * FROM ventas 
				WHERE MONTH(ventas.fecha) = '".$month."'
				AND YEAR(ventas.fecha) = '".$year."'
				AND idEmpresa = '".$empresa["empresaId"]."'
				AND status = 'pagado'
				ORDER BY fecha DESC");
			echo $this->Util()->DB()->query;
			$folios = $this->Util()->DB()->GetResult();
			
			foreach($folios as $keyFolio => $folio)
			{
				$data["nuevosFolios"] += $folio["cantidad"];
				$data["ventasFolios"] += $folio["cantidad"] * $preciosFolios[$folio["cantidad"]];
				$ventasFolios = $folio["cantidad"] * $preciosFolios[$folio["cantidad"]];
				$data["ventasFoliosIVA"] += $ventasFolios * $iva;
				
				$data["pagoEdicom"] += $folio["cantidad"] * $pagoEdicom;
				$data["ventasFoliosDespuesPagoEdicom"] = $data["ventasFoliosIvaIncluido"] - $data["pagoEdicom"];
				
				if($empresa["socioId"] == 5)
				{
					$data["gananciasFoliosAvantika"] = $data["ventasFoliosDespuesPagoEdicom"] * $porcentajeVendio;
					$data["gananciasFoliosTrazzos"] = $data["ventasFoliosDespuesPagoEdicom"] * $porcentajeSobrante;
					$data["pagoEdicomAvantika"] += $folio["cantidad"] * $pagoEdicom;
				}
				else
				{
					$data["gananciasFoliosAvantika"] = $data["ventasFoliosDespuesPagoEdicom"] * $porcentajeSobrante;
					$data["gananciasFoliosTrazzos"] = $data["ventasFoliosDespuesPagoEdicom"] * $porcentajeVendio;
					$data["pagoEdicomTrazzos"] += $folio["cantidad"] * $pagoEdicom;
				}
				
				$data["totalPagos"] = $data["gananciasFoliosAvantika"] + $data["gananciasFoliosTrazzos"] + $data["pagoEdicom"]; 
				
			}
			echo $data["ventasFoliosIvaIncluido"] = $data["ventasFolios"] +$data["ventasFoliosIVA"];
			
		}
		$data["devolucionTrazzosMasFolios"] = $data["devolucionTrazzosIVAIncluido"] + $data["gananciasFoliosTrazzos"];
		$data["trazzosCompensacion"] = $data["devolucionTrazzosMasFolios"] - $data["pagoEdicomTrazzos"];	
		$data["trazzosFacturaDe"] = $data["trazzosCompensacion"] / (1 + $iva);
		
		$data = urlencode(serialize($data));
		//insert
		$this->Util()->DB()->setQuery("
			INSERT INTO  `reporte` ( 
				`date` ,
				`data`
				) VALUES ( '".$_GET["year"]."-".$_GET["month"]."-30', '".$data."')");
		$this->Util()->DB()->InsertData();
		echo "Reporte generado";
		echo "</pre>";
		//print_r($result);
		return $data;
	}

	function get_months($startstring, $endstring)
	{	
		$time1  = strtotime($startstring);//absolute date comparison needs to be done here, because PHP doesn't do date comparisons
		$time2  = strtotime($endstring);
		$my1     = date('mY', $time1); //need these to compare dates at 'month' granularity
		$my2    = date('mY', $time2);
		$year1 = date('Y', $time1);
		$year2 = date('Y', $time2);
		$years = range($year1, $year2);
	 
		foreach($years as $year)
		{
			$months[$year] = array();
			while($time1 < $time2)
			{
				if(date('Y',$time1) == $year)
				{
					$months[$year][] = date('m', $time1);
					$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
				}
				else
				{
					break;
				}
			}
			continue;
		}
		return $months;
	}	
	
	function NewReport()
	{
		$date = date("Y-m-d");
		$montharr = $this->get_months('2011-03-01', date("Y-m-d"));
		krsort($montharr);
		
		foreach($montharr as $key => $value)
		{
			krsort($montharr[$key]);
		}

		$precios = array(
			50 => 400,
			100 => 700,
			150 => 900,
			200 => 1200,
			300 => 1300,
			500 => 1500,
			1000 => 2500,
			1500 => 3000
		);

		$preciosBraun = array(
			100 => 500,
			150 => 700,
			200 => 800,
			500 => 1500,
			1000 => 2500,
			2000 => 4000
		);

		$preciosBraunInterno = array(
			50 => 50,
			100 => 100,
			150 => 150,
			200 => 200,
			500 => 500,
			1000 => 1000,
			2000 => 2000
		);

		$data = array();
		//print_r($montharr);
		foreach($montharr as $key => $year)
		{
			$data[$key] = array();
			
			foreach($year as $keyMonth => $month)
			{
				$data[$key][$keyMonth] = array();
				$this->Util()->DB()->setQuery("SELECT * FROM ventas 
					WHERE MONTH(ventas.fecha) = '".$month."'
					AND YEAR(ventas.fecha) = '".$key."'
					AND status = 'pagado'
					ORDER BY idVenta DESC");
					//echo $this->Util()->DB()->query;
				$ventas = $this->Util()->DB()->GetResult();
				
				$data[$key][$keyMonth]["ingresoPorFolios"] = 0;
				foreach($ventas as $venta)
				{
					//from braun (rfc and internono
					if($venta["interno"] == "No" && $venta["rfc"] != "")
					{
						$data[$key][$keyMonth]["ingresoPorFoliosBraun"] += $preciosBraun[$venta["cantidad"]];
						$data[$key][$keyMonth]["noVentasBraun"] ++;
						$data[$key][$keyMonth]["foliosBraun"] += $venta["cantidad"];
					}
					elseif($venta["interno"] == "Si")
					{
						$data[$key][$keyMonth]["ingresoPorFoliosBraunInterno"] += $preciosBraunInterno[$venta["cantidad"]];
						$data[$key][$keyMonth]["noVentasBraunInterno"] ++;
						$data[$key][$keyMonth]["foliosBraunInterno"] += $venta["cantidad"];
					}
					else
					{
					//print_r($venta);
						$data[$key][$keyMonth]["ingresoPorFolios"] += $precios[$venta["cantidad"]];
						$data[$key][$keyMonth]["noVentas"] ++;
						$data[$key][$keyMonth]["folios"] += $venta["cantidad"];
					}
				}

				$this->Util()->DB()->setQuery("SELECT * FROM nominas 
					WHERE MONTH(nominas.fecha) = '".$month."'
					AND YEAR(nominas.fecha) = '".$key."'
					AND status = 'pagado'
					AND mostrar = 'Si'
					ORDER BY fecha DESC");
					//echo $this->Util()->DB()->query;
				$ventas = $this->Util()->DB()->GetResult();
				//$data[$key][$keyMonth]["ventas"] = $ventas;
				
				$data[$key][$keyMonth]["ingresoPorNominas"] = 0;
				$data[$key][$keyMonth]["noNominas"] = 0;
				foreach($ventas as $venta)
				{
					//print_r($venta);
					$data[$key][$keyMonth]["ingresoPorNomina"] += 1000;
					$data[$key][$keyMonth]["noNominas"] ++;
				}

				$this->Util()->DB()->setQuery("SELECT * FROM impuestos 
					WHERE MONTH(impuestos.fecha) = '".$month."'
					AND YEAR(impuestos.fecha) = '".$key."'
					AND status = 'pagado'
					AND mostrar = 'Si'
					ORDER BY fecha DESC");
					//echo $this->Util()->DB()->query;
				$ventas = $this->Util()->DB()->GetResult();
				//$data[$key][$keyMonth]["ventas"] = $ventas;
				
				$data[$key][$keyMonth]["noImpuestos"] = 0;
				$data[$key][$keyMonth]["ingresoPorImpuestos"] = 0;
				foreach($ventas as $venta)
				{
					//print_r($venta);
					$data[$key][$keyMonth]["ingresoPorImpuestos"] += 1600;
					$data[$key][$keyMonth]["noImpuestos"] ++;
				}
				
				$ingresoTotal = $data[$key][$keyMonth]["ingresoPorFoliosBraunInterno"] + $data[$key][$keyMonth]["ingresoPorFoliosBraun"] + $data[$key][$keyMonth]["ingresoPorImpuestos"] + $data[$key][$keyMonth]["ingresoPorNomina"] + $data[$key][$keyMonth]["ingresoPorFolios"];
				$data[$key][$keyMonth]["ingresoTotal"] += $ingresoTotal; 
				$data[$key][$keyMonth]["mes"] = $this->Util()->ConvertirMes($keyMonth + 1);
				
				$result["total"] += $data[$key][$keyMonth]["ingresoTotal"];
				$result["meses"] ++;
			}
		}
		$result["years"] = $data;
		$result["promedio"] = $result["total"] / $result["meses"];
		//print_r($result);
		return $result;
		
	}
	
	function Division()
	{
		$this->Util()->DB()->setQuery("SELECT empresa.empresaId, moduloNomina, moduloImpuestos, nombre, venNomina, venImpuestos FROM empresa 
				LEFT JOIN usuarios ON usuarios.idUsuario = empresa.socioContacto WHERE (empresaId != 15 && empresaId != 63 && empresaId != 116)
				ORDER BY empresa.empresaId DESC ");
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $empresa)
		{
			$data[$empresa["empresaId"]]["nomina"] = "No";
			$data[$empresa["empresaId"]]["impuesto"] = "No";
			
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM facturas_".$empresa["empresaId"].".comprobante");			
			$data[$empresa["empresaId"]]["facturasExpedidas"] += $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT fecha FROM facturas_".$empresa["empresaId"].".comprobante ORDER BY fecha DESC");			
			$data[$empresa["empresaId"]]["fecha"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();

			$data[$empresa["empresaId"]]["nomina"] = $empresa["moduloNomina"];
			$data[$empresa["empresaId"]]["impuesto"] = $empresa["moduloImpuestos"];
			$data[$empresa["empresaId"]]["venNomina"] = $empresa["venNomina"];
			$data[$empresa["empresaId"]]["venImpuestos"] = $empresa["venImpuestos"];

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT razonSocial FROM facturas_".$empresa["empresaId"].".rfc ");			
			$data[$empresa["empresaId"]]["razonSocial"] = urldecode($this->Util()->DBSelect($empresa["empresaId"])->GetSingle());

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT municipio FROM facturas_".$empresa["empresaId"].".rfc ");			
			$data[$empresa["empresaId"]]["ciudad"] = urldecode($this->Util()->DBSelect($empresa["empresaId"])->GetSingle());

			$data[$empresa["empresaId"]]["socio"] = $empresa["nombre"];
			$data[$empresa["empresaId"]]["empresaId"] = $empresa["empresaId"];
		
			$fechaHoy = date("Y-m-d H:i:s");
			$hoy = strtotime($fechaHoy);
			$fecha = strtotime($data[$empresa["empresaId"]]["fecha"]);
			$diferencia = $hoy - $fecha;
			$data[$empresa["empresaId"]]["diasSinFacturar"] = floor($diferencia / 86400);
			
			//obtener compras de cada uno
			$this->Util()->DB()->setQuery("SELECT cantidad FROM ventas WHERE idEmpresa = '".$empresa["empresaId"]."' AND fecha > '2014-12-31'");
			$data[$empresa["empresaId"]]["ventas"] = $this->Util()->DB()->GetResult();
			
		}

$costos = array(
	1 => 0,
	2 => 0,
	10 => 0,
	15 => 0,
	25 => 250,
	40 => 400,
	50 => 400,
	100 => 700,
	150 => 900,
	200 => 1200,
	300 => 1300,
	500 => 1500,
	1000 => 2500,
	1500 => 3000,
	2000 => 4000,
); 
		
		//dias sin facturar > 180
		$sinFacturar = array();
		$facturas = 0;
		foreach($data as $key => $value)
		{
			if($value["diasSinFacturar"] < 90)
			{
				$sinFacturar[$key] = $value;
				$facturas += $value["facturasExpedidas"];
				unset($data[$key]);
			}
		}

		echo "Sin Facturar";		
		echo count($sinFacturar);
		echo " ".$facturas;
		echo "\n<br>";
		
		//print_r($sinFacturar);

		$impuestosNomina = array();
		$facturas = 0;
		foreach($data as $key => $value)
		{
			if(($value["impuesto"] == "Si" && $value["venImpuestos"] > $fechaHoy) && ($value["nomina"] == "Si" && $value["venNomina"] > $fechaHoy))
			{
				$impuestosNomina[$key] = $value;
				$facturas += $value["facturasExpedidas"];
				
				//checar ultima compra de folios
				$this->Util()->DB()->setQuery("SELECT cantidad FROM ventas");
				$result = $this->Util()->DB()->GetSingle();
				
				unset($data[$key]);
			}
		}

		echo "Modulo de Impuestos y Nomina";		
		echo count($impuestosNomina);
		echo " ".$facturas;
		echo "\n<br>";
		
?>	

<table border="1" style="font-size:10px">
<tr>
	<td>Id Empresa</td>
	<td>Razon Social</td>
	<td>Sociio</td>
	<td>Ciudad</td>
	<td>Ingreso Modulo Impuestos</td>
	<td>Ingreso Modulo Nomina</td>
	<td>Ingreso Folios</td>
	<td>Ingresos Totales</td>
</tr>
<?php 
$totales = 0;
$granTotal = 0;
foreach($impuestosNomina as $value)
{
	$costo = 0;
	foreach($value["ventas"] as $venta)
	{
		$costo += $costos[$venta["cantidad"]]; 
	}
	$total =  $costo + 1600 + 1000;
	$totales += $total;
?>
<tr>
	<td><?php echo $value["empresaId"] ?></td>
	<td><?php echo $value["razonSocial"] ?></td>
	<td><?php echo $value["socio"] ?></td>
	<td><?php echo $value["ciudad"] ?></td>
	<td>1600</td>
	<td>1000</td>
	<td><?php echo $costo ?></td>
	<td><?php echo $total ?></td>
</tr>
<?php 
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo $totales ?></td>
</tr>

</table>

<?php			
		
		$impuestos = array();
		$facturas = 0;
		foreach($data as $key => $value)
		{
			if($value["impuesto"] == "Si" && $value["venImpuestos"] > $fechaHoy)
			{
				$impuestos[$key] = $value;
				$facturas += $value["facturasExpedidas"];
				unset($data[$key]);
			}
		}
		echo "Modulo de Impuestos";		
		echo count($impuestos);
		echo " ".$facturas;
		echo "\n<br>";

		
?>

<table border="1" style="font-size:10px">
<tr>
	<td>Id Empresa</td>
	<td>Razon Social</td>
	<td>Sociio</td>
	<td>Ciudad</td>
	<td>Ingreso Modulo Impuestos</td>
	<td>Ingreso Modulo Nomina</td>
	<td>Ingreso Folios</td>
	<td>Ingresos Totales</td>
</tr>
<?php 
$granTotal += $totales;
$totales = 0;
foreach($impuestos as $value)
{
	$costo = 0;
	foreach($value["ventas"] as $venta)
	{
		$costo += $costos[$venta["cantidad"]]; 
	}
	$total =  $costo + 1600;
	$totales += $total;
?>
<tr>
	<td><?php echo $value["empresaId"] ?></td>
	<td><?php echo $value["razonSocial"] ?></td>
	<td><?php echo $value["socio"] ?></td>
	<td><?php echo $value["ciudad"] ?></td>
	<td>1600</td>
	<td>0</td>
	<td><?php echo $costo ?></td>
	<td><?php echo $total ?></td>
</tr>
<?php 
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo $totales ?></td>
</tr>

</table>
<?php 		
		
		$nominas = array();
		$facturas = 0;
		foreach($data as $key => $value)
		{
			if($value["nomina"] == "Si" && $value["venNomina"] > $fechaHoy)
			{
				$nominas[$key] = $value;
				$facturas += $value["facturasExpedidas"];
				unset($data[$key]);
			}
		}
		echo "Modulo de Nominas";		
		echo count($nominas);
		echo " ".$facturas;
		echo "\n<br>";		
?>
<table border="1" style="font-size:10px">
<tr>
	<td>Id Empresa</td>
	<td>Razon Social</td>
	<td>Sociio</td>
	<td>Ciudad</td>
	<td>Ingreso Modulo Impuestos</td>
	<td>Ingreso Modulo Nomina</td>
	<td>Ingreso Folios</td>
	<td>Ingresos Totales</td>
</tr>
<?php 
$granTotal += $totales;
$totales = 0;
foreach($nominas as $value)
{
	$costo = 0;
	foreach($value["ventas"] as $venta)
	{
		$costo += $costos[$venta["cantidad"]]; 
	}
	$total =  $costo + 1000;
	$totales += $total;
?>
<tr>
	<td><?php echo $value["empresaId"] ?></td>
	<td><?php echo $value["razonSocial"] ?></td>
	<td><?php echo $value["socio"] ?></td>
	<td><?php echo $value["ciudad"] ?></td>
	<td>0</td>
	<td>1000</td>
	<td><?php echo $costo ?></td>
	<td><?php echo $total ?></td>
</tr>
<?php 
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo $totales ?></td>
</tr>

</table>
<?php 		

		$folios = array();
		$facturas = 0;
		foreach($data as $key => $value)
		{
				$folios[$key] = $value;
				$facturas += $value["facturasExpedidas"];
				unset($data[$key]);
		}
		echo "Solo Folios";		
		echo count($folios);
		echo " ".$facturas;
		echo "\n<br>";		

?>
<table border="1" style="font-size:10px">
<tr>
	<td>Id Empresa</td>
	<td>Razon Social</td>
	<td>Socio</td>
	<td>Ciudad</td>
	<td>Ingreso Modulo Impuestos</td>
	<td>Ingreso Modulo Nomina</td>
	<td>Ingreso Folios</td>
	<td>Ingresos Totales</td>
</tr>
<?php 
$granTotal += $totales;
$totales = 0;
foreach($folios as $value)
{
	$costo = 0;
	foreach($value["ventas"] as $venta)
	{
		$costo += $costos[$venta["cantidad"]]; 
	}
	$total =  $costo;
	$totales += $total;
?>
<tr>
	<td><?php echo $value["empresaId"] ?></td>
	<td><?php echo $value["razonSocial"] ?></td>
	<td><?php echo $value["socio"] ?></td>
	<td><?php echo $value["ciudad"] ?></td>
	<td>0</td>
	<td>0</td>
	<td><?php echo $costo ?></td>
	<td><?php echo $total ?></td>
</tr>
<?php 
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><?php echo $totales ?></td>
</tr>

</table>
Total: 
<?php 
echo $granTotal += $totales;
?>
<br />
Entre 2
<?php 
echo $granTotal / 2;



//		print_r($impuestos);
		
//		print_r($data);*/
		exit;

		return $result;
		
	}
	

}

?>