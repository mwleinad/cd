<?php
		
	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');

	session_start();
	
	foreach($_POST as $key => $val)
		$values[$key] = $val;
		
	$comprobantes = array();
	$comprobantes = $nomina->SearchNominaByRfc($values);	

	$totales = [];
	$totales['sueldo'] = 0;
		 
	$totales['primaVacacional'] = 0;
	$totales['primaDominical'] = 0;
	$totales['subsidioEmpleo'] = 0;
	$totales['totalPercepciones'] = 0;
	
	$totales['seguridadSocial'] = 0;
	$totales['isr'] = 0;
	$totales['pagoCreditoVivienda'] = 0;
	$totales['ausencia'] = 0;
	$totales['pensionAlimenticia'] = 0;
	$totales['cuotasSindicales'] = 0;
	$totales['totalDeducciones'] = 0;
	$totales['netoPagar'] = 0;
	
	$rfcActivo = $comprobante->getRfcActive();
	$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/";	
	
	$facturas = '';
	foreach($comprobantes['items'] as $fac){
						
		$xmlFile = $root.'facturas/xml/SIGN_'.$fac['xml'].'.xml';
		
		if(!file_exists($xmlFile))
			continue;
		
		$xml = simplexml_load_file($xmlFile);
		$ns = $xml->getNamespaces(true);
		$xml->registerXPathNamespace('c', $ns['cfdi']);
		$xml->registerXPathNamespace('t', $ns['tfd']);
		$xml->registerXPathNamespace('n', $ns['nomina12']);
		
		foreach ($xml->xpath('//c:Comprobante') as $val){
			$serie =  $val['serie'];
			$folio =  $val['folio'];
		}
		
		$sueldo = 0;
		$primaVacacional = 0;
		$primaDominical = 0;
		$subsidioEmpleo = 0;
		$transporte = 0;
		$otrosIngresos = 0;
		$gratificacion = 0;
		$primaAntiguedad = 0;
		foreach ($xml->xpath('//n:Nomina//n:Percepciones//n:Percepcion') as $perc){

			$total = floatval($perc['ImporteGravado']) + floatval($perc['ImporteExento']);
			
			if($perc['Clave'] == '001')
				$sueldo = $total;
			if($perc['Clave'] == '021') 
				$primaVacacional = $total;
			if($perc['Clave'] == '020') 
				$primaDominical = $total;
			if($perc['Clave'] == '017') 
				$subsidioEmpleo = $total;
			if($perc['Clave'] == '036') 
				$transporte = $total;
			if($perc['Clave'] == '038') 
				$otrosIngresos = $total;
			if($perc['Clave'] == '002') 
				$gratificacion = $total;
			if($perc['Clave'] == '022') 
				$primaAntiguedad = $total;
			
		}//foreach

		$totalPercepciones = $sueldo + $primaVacacional + $primaDominical + $subsidioEmpleo + $transporte;
		$totalPercepciones += $otrosIngresos + $gratificacion + $primaAntiguedad;
		
		$seguridadSocial = 0;
		$isr = 0;
		$pagoCreditoVivienda = 0;
		$ausencia = 0;
		$pensionAlimenticia = 0;
		$cuotasSindicales = 0;
		$infonacot = 0;
		$incapacidad = 0;
		foreach ($xml->xpath('//n:Nomina//n:Deducciones//n:Deduccion') as $deduc){
			
			//$total = floatval($deduc['ImporteGravado']) + floatval($deduc['ImporteExento']);
            $total = floatval($deduc['Importe']);
			
			if($deduc['Clave'] == '001') 
				$seguridadSocial = $total;
			if($deduc['Clave'] == '002') 
				$isr = $total;
            if($deduc['Clave'] == '004')
                $otros += $total;
			if($deduc['Clave'] == '010')
				$pagoCreditoVivienda = $total;
			if($deduc['Clave'] == '020') 
				$ausencia = $total;
			if($deduc['Clave'] == '007') 
				$pensionAlimenticia = $total;
			if($deduc['Clave'] == '019') 
				$cuotasSindicales = $total;
			if($deduc['Clave'] == '011') 
				$infonacot = $total;
			if($deduc['Clave'] == '006') 
				$incapacidad = $total;
			
		}//foreach
		
		$totalDeducciones = $seguridadSocial + $isr + $pagoCreditoVivienda + $ausencia + $pensionAlimenticia + $otros;
		$totalDeducciones += $cuotasSindicales + $infonacot + $incapacidad;
		
		$netoPagar = $totalPercepciones - $totalDeducciones;
		
		$facturas .= "
		<tr>
			<td style=\"text-align:left;\">".$fac['nombre']."</td>
			<td style=\"text-align:center;\">".$fac['rfc']."</td>
			<td style=\"text-align:center;\">".$serie.$folio."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$sueldo."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$primaVacacional."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$primaDominical."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$subsidioEmpleo."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$transporte."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$otrosIngresos."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$gratificacion."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$primaAntiguedad."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$totalPercepciones."</td>
			<td style=\"text-align:center;\"></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$seguridadSocial."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$isr."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$pagoCreditoVivienda."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$ausencia."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$pensionAlimenticia."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$cuotasSindicales."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$infonacot."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$incapacidad."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$otros."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$totalDeducciones."</td>
			<td style=\"text-align:right;mso-number-format:'0.00';\">".$netoPagar."</td>
		</tr>";	
		
		$totales['sueldo'] += $sueldo;
		
		$totales['primaVacacional'] += $primaVacacional;
		$totales['primaDominical'] += $primaDominical;
		$totales['subsidioEmpleo'] += $subsidioEmpleo;
		$totales['transporte'] += $transporte;
		$totales['otrosIngresos'] += $otrosIngresos;
		$totales['gratificacion'] += $gratificacion;
		$totales['primaAntiguedad'] += $primaAntiguedad;
		$totales['totalPercepciones'] += $totalPercepciones;
		
		$totales['seguridadSocial'] += $seguridadSocial;
		$totales['isr'] += $isr;
		$totales['pagoCreditoVivienda'] += $pagoCreditoVivienda;
		$totales['ausencia'] += $ausencia;
		$totales['pensionAlimenticia'] += $pensionAlimenticia;
		$totales['cuotasSindicales'] += $cuotasSindicales;
		$totales['infonacot'] += $infonacot;
		$totales['incapacidad'] += $incapacidad;
		$totales['totalDeducciones'] += $totalDeducciones;
		$totales['netoPagar'] += $netoPagar;
		
	}//foreach
					
	$x = "<table border=\"1\">
	<thead> 
		<tr>
			<th style=\"background:#CCC;text-align:center\" colspan='23'>
				<b>".$mes." ".$anio."</b>
			</th>
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th colspan='10'><b>PERCEPCIONES</b></th>
			<th></th>
			<th colspan='10'><b>DEDUCCIONES</b></th>
		</tr>
		<tr>
			<th style=\"background:#E0E5E7;text-align:center\"><b>EMPLEADO</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>RFC</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>FOLIO</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>SUELDO</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>PRIMA VACACIONAL</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>PRIMA DOMINICAL</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>SUBSIDIO</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>AYUDA PARA TRANSPORTE</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>OTROS INGRESOS POR SALARIOS</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>GRATIFICACION ANUAL</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>PRIMA POR ANTIGUEDAD</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>TOTAL PERCEPCIONES</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>IMSS</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>ISR</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>INFONAVIT</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>FALTAS</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>PENSION ALIMENTICIA</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>CUOTA SINDICAL</b></th>			
			<th style=\"background:#E0E5E7;text-align:center\"><b>PAGO DE ABONOS INFONACOT</b></th>			
			<th style=\"background:#E0E5E7;text-align:center\"><b>DESCUENTO POR INCAPACIDAD</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>OTROS</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>TOTAL DEDUCCIONES</b></th>
			<th style=\"background:#E0E5E7;text-align:center\"><b>NETO A PAGAR</b></th>
		</tr>
	</thead>
	<tbody>";
	
	$x .= $facturas;
	
	
	$x .= "
		<tr>
			<td style=\"text-align:left;\"><b>TOTALES</b></td>
			<td style=\"text-align:center;\"></td>
			<td style=\"text-align:center;\"></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['sueldo']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['primaVacacional']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['primaDominical']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['subsidioEmpleo']."</b></td>	
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['transporte']."</b></td>	
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['otrosIngresos']."</b></td>	
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['gratificacion']."</b></td>	
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['primaAntiguedad']."</b></td>	
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['totalPercepciones']."</b></td>
			<td style=\"text-align:center;\"></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['seguridadSocial']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['isr']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['pagoCreditoVivienda']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['ausencia']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['pensionAlimenticia']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['cuotasSindicales']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['infonacot']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['incapacidad']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['totalDeducciones']."</b></td>
			<td style=\"text-align:right;mso-number-format:'0.00';\"><b>".$totales['netoPagar']."</b></td>
		</tr>";
	
	$x .= "
	</tbody>
	</table>";
			
	$name = 'Reporte_Nominas';
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-type:   application/x-msexcel; charset=utf-8");
	header("Content-Disposition: attachment; filename=".$name.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo $x;
																	
	exit;

?>