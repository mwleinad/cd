<?php
	
	include_once('init.php');
	include_once('config.php');
	include_once(DOC_ROOT.'/libraries.php');
	
	$lineSeparator = "\n";
	$fieldSeparator = ",";
	$csvFile = 'productos.csv';
	
	if(!file_exists($csvFile)){
		echo 'No se encuentra el archivo '.$csvFile;
		exit;	
	}//if
	
	$file = fopen($csvFile, 'r');
	
	if(!$file){
		echo 'Error al abrir el archivo';
		exit;	
	}//if
	
	$size = filesize($csvFile);
	
	if(!$size){
		echo 'El archivo esta vacio, verifique';
		exit;
	}//if
	
	$lines = 0;
	$regs = 0;
	$promotores = array();
	$empresaId = 130;
	while (( $field = fgetcsv($file,2048,",")) !== false ) { // Mientras hay líneas que leer...
					
		//Clientes	
		if($lines == 0)
		{
			$lines++;
			continue;
		}
	//	print_r($field);			
	$field[4] = str_replace("'", " ", $field[4]);
	$field[4] = str_replace("\"", " ", $field[4]);

		$sqlQuery = 'SELECT rfcId FROM rfc WHERE activo = "si" AND empresaId = '.$empresaId;
		$util->DBSelect($empresaId)->setQuery($sqlQuery);
		$rfc = $util->DBSelect($empresaId)->GetSingle();
				
		$util->DBSelect($empresaId)->setQuery("
			INSERT INTO `producto` (
				`empresaId`,
				`noIdentificacion`,
				`unidad`, 
				`valorUnitario`, 
				`descripcion`, 
				`rfcId`		
				) 
			VALUES (
				'".$empresaId."',
				'".$field[2]."',				
				'".$field[1]."',
				'".$field[4]."',
				'".$field[3]."',
				'".$rfc."')"
			);
			//echo $util->DBSelect($empresaId)->query;;
			$id_producto = $util->DBSelect($empresaId)->InsertData();
//			break;

			
			echo '<br>Saved<br><br>';
		$lines++;	
			
		echo '<br>';
		
	}//while
	
	fclose($file);
		
	echo '<br><br>Done!';
		
	echo $lines.' registers imported.';
			
	exit;

?>