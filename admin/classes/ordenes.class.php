<?php
class Ordenes extends Main
{
	private $tipo;
	private $id;
	private $cantidad;
	private $status;
	public $empresaId;
	public $idUsuario;
	public $mes="todos";
	public $vencimiento="todos";
	public $socioId=0;
	public $version="todos";
	
	
	public function setVersion($value){
	$this->version=$value;
	}
	
	
	public function setSocioId($value){
	
	$this->socioId=$value;
	//print_r($this->socioId); exit;
	}
	
	
	public function setVencimiento($value){
	$this->vencimiento=$value;
	}
	
		
	public function setMes($value){
	$this->mes=$value;
	}	
	
	public function setIdUsuario($value){
	$this->idUsuario=$value;
	
	}
	
	public function setEmpresaId($value){
	$this->empresaId=$value;
	}
	
	//public function setTipo($value)
	//{
		//$this->tipo = $value;
	//}

	public function setTipo($value)
	{
		$this->tipo = $value;
	}

	public function getTipo()
	{
		return $this->tipo;
	}
	public function setStatus($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'status');
		$this->status = $value;
	}

	public function getStatus()
	{
		return $this->status;
	}
	public function setCantidad($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'cantidad');
		$this->cantidad = $value;
	}

	public function getCantidad()
	{
		return $this->cantidad;
	}
	
	public function setId($value)
	{
		$this->id = $value;
	}

	public function getId()
	{
		return $this->id;
	}
    
	 public function InfoEmpresa(){
	 $sql="select * from empresa where empresaId='".$this->empresaId."'";
	 $this->Util()->DB()->setQuery($sql);
	 $result = $this->Util()->DB()->GetRow();

			$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM empresa WHERE empresaId = '".$result["socioId"]."'");
			$countSocioId = $this->Util()->DB()->GetSingle();

			if($countSocioId)
			{
				$this->Util()->DBSelect($result["socioId"])->setQuery("SELECT * FROM ".DB_PREFIX.$result["socioId"].".rfc LIMIT 1");
				$result["socio"] = $this->Util()->DBSelect($result["socioId"])->GetRow(); 
				
				$sql="select nombre from usuarios where idUsuario='".$result["socioId"]."'";
				$this->Util()->DB()->setQuery($sql);
				$result["socio"]["razonSocial1"] = $this->Util()->DB()->GetSingle();
			}
			else
			{  
				$sql="select nombre from usuarios where idUsuario='".$result["socioId"]."'";
				$this->Util()->DB()->setQuery($sql);
				$result["socio"]["razonSocial1"] = $this->Util()->DB()->GetSingle();
				$result["socio"]["razonSocial"] = "Facturasexxxx";
			}
			$result["socio"]["razonSocial"] = utf8_decode($result[$key]["socio"]["razonSocial"]);

			$this->Util()->DBSelect($result["empresaId"])->setQuery("SELECT * FROM ".DB_PREFIX.$result["empresaId"].".rfc LIMIT 1");
			$result["rfc"] = $this->Util()->DBSelect($result["empresaId"])->GetRow();
			
			$result["rfc"]["razonSocial"] = utf8_decode(urldecode($result["rfc"]["razonSocial"]));
			$result["rfc"]["localidad"] = utf8_decode(urldecode($result["rfc"]["localidad"]));
			
			$this->Util()->DBSelect($result["empresaId"])->setQuery("SELECT COUNT(*) FROM ".DB_PREFIX.$result["empresaId"].".comprobante WHERE empresaId = ".$result["empresaId"]." LIMIT 1");			
			$result["expedidos"] = $this->Util()->DBSelect($result["empresaId"])->GetSingle();

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT fecha FROM ".DB_PREFIX.$result["empresaId"].".comprobante ORDER BY fecha DESC LIMIT 1");			
			$result["ultimaExpedida"] = $this->Util()->DBSelect($result["empresaId"])->GetSingle();
			
			$sql="select email from usuario where empresaId='".$result["empresaId"]."' AND main = 'Si'";
			$this->Util()->DB()->setQuery($sql);
			$result["email"] = $this->Util()->DB()->GetSingle();

			$sql="select password from usuario where empresaId='".$result["empresaId"]."' AND main = 'Si'";
			$this->Util()->DB()->setQuery($sql);
			$result["password"] = $this->Util()->DB()->GetSingle();
	 
	  return $result;
	 }
	 public function EnumerateUsuario()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM usuarios where idUsuario="'.$this->idUsuario.'" ORDER BY idUsuario ASC');
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $row){
		   $sql="select paqFoliosId from compraFolios where userId='".$row['idUsuario']."'";
		   $this->Util()->DB()->setQuery($sql);
		  $response = $this->Util()->DB()->GetResult();
		  $totalFolios=0;
		  foreach($response as $a => $fila){
		      
			  $paqs = new PaqFolios;
			  $paqs -> setPaqFoliosId($fila['paqFoliosId']);
			  $infoPaq = $paqs->Info();
			  $totalFolios+=$infoPaq['cantidad'];
			  
		   
		   }
		  $result[$key]['totalFolios']=$totalFolios;
		  $sql="select limite from empresa where socioId='".$row['idUsuario']."'";
		  $this->Util()->DB()->setQuery($sql);
		  $consumidos = $this->Util()->DB()->GetResult();
		  $totalConsumidos=0;
		 if(count($consumidos)>0){
		 foreach($consumidos as $a => $fila){
		      $totalConsumidos+=$fila['limite'];
		      
		  }}
		  $result[$key]['restantes']=$result[$key]['totalFolios']-$totalConsumidos;
			 
		}
		return $result;
	}
	
		public function OrdenesListaT()
	{
	  
		global $months;
		if($_SESSION['tipo'] == "admin"){
			$this->Util()->DB()->setQuery('
			SELECT empresaId FROM empresa WHERE borrar = "No"');
		}else if($_SESSION['tipo'] == "partner" || $_SESSION['tipo']=="partnerPro"){
	     $sql='SELECT empresaId FROM empresa 
					WHERE borrar = "No" AND empresa.socioId="'.$_SESSION['loginKey'].'"';
				$this->Util()->DB()->setQuery($sql);
		}
		 
		$result = $this->Util()->DB()->GetResult();
		foreach($result as $key => $empresa)
		{

			if($empresa["tipoSocio"] == "proveedor")
			{
				unset($result[$key]);
				continue;
			}

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT rfc, razonSocial FROM ".DB_PREFIX.$empresa["empresaId"].".rfc LIMIT 1");
			$rfc = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			
			$result[$key]["rfc"] = utf8_decode(urldecode($rfc["rfc"]));
			$result[$key]["razonSocial"] = utf8_decode(urldecode($rfc["razonSocial"]));
		}// end foreach result 
		
		$result = $this->Util()->orderMultiDimensionalArray ($result, "razonSocial");
				
		return $result;
	
	}
	
	
	
	public function OrdenesLista($borrar = "No")
	{
	  
		global $months;
		
	$orderBy = "empresa.empresaId DESC";
		
	if($this->socioId!=0){
		if($_SESSION['tipo'] == "admin"){
			$filtro=' WHERE borrar = "'.$borrar.'" AND empresa.socioId="'.$this->socioId.'"';
		}
	}else{
	  $filtro=' WHERE borrar = "'.$borrar.'"';
	}

	if($_POST["inactivos"])
	{
	  $filtro .=' AND activo = "0"';
	}
	else
	{
	  $filtro .=' AND activo = "1"';
	}
	if($this->mes && $this->mes != "todos")
	{
	  $filtro .=' AND MONTH(vencimiento) = "'.$this->mes.'"';
	}

	if($this->vencimiento)
	{
		$time = date("Y-m-d");
		$noVencidos = date("Y-m-d",time() + (24 * 3600 * 30));
		switch($this->vencimiento)
		{
			//mas de 30 dias
			case "novencido": 
				$filtro .=' AND vencimiento >= "'.$noVencidos.'"';break;
			case "porvencer": 
				$filtro .=' AND vencimiento <= "'.$noVencidos.'" AND vencimiento > "'.$time.'"';break;
			case "vencido": 
				$filtro .=' AND vencimiento <= "'.$time.'"';break;
		}
//	  $filtro .=' AND MONTH(vencimiento) = "'.$this->mes.'"';
	}

	if($this->version && $this->version != "todos")
	{
			$filtro .=' AND version = "'.$this->version.'"';
	}

	if($this->socioId && $this->socioId != "todos")
	{
			$filtro .=' AND socioId = "'.$this->socioId.'"';
	}
	if($_SESSION['tipo'] == "admin")
	{
		$sql = 'SELECT *, empresa.empresaId as empresaId FROM empresa 
				LEFT JOIN usuario ON usuario.empresaId = empresa.empresaId '.$filtro.'
				GROUP BY empresa.empresaId 										
				ORDER BY '.$orderBy;
		$this->Util()->DB()->setQuery($sql);
	} 
	else if($_SESSION['tipo'] == "partner" || $_SESSION['tipo'] == "comisionista" || $_SESSION['tipo'] == "partnerPro")
	{
		 $sql='SELECT * FROM empresa 
				LEFT JOIN usuario ON usuario.empresaId = empresa.empresaId '.$filtro.'	AND empresa.socioId="'.$_SESSION['loginKey'].'"	
				GROUP BY empresa.empresaId 						
				ORDER BY '.$orderBy;
			
			$this->Util()->DB()->setQuery($sql);
	}
	
	$result = $this->Util()->DB()->GetResult();
	
	
	//echo "<pre>";	
		$meses['Enero']=array();
		$meses['Febrero']=array();
		$meses['Marzo']=array();
		$meses['Abril']=array();
		$meses['Mayo']=array();
		$meses['Junio']=array();
		$meses['Julio']=array();
		$meses['Agosto']=array();
		$meses['Septiembre']=array();
		$meses['Octubre']=array();
		$meses['Noviembre']=array();
		$meses['Diciembre']=array();
		
		  //echo "<pre>";
		  //print_r($meses); 
		
		//print_r($result);
		foreach($result as $key => $empresa)
		{
			//total costo
			if($empresa["costo"] == 0)
			{
				$empresa["costo"] = COSTO_SISTEMA;
			}
			
			if($empresa["costoModuloNomina"] == 0)
			{
				$empresa["costoModuloNomina"] = COSTO_NOMINA;
			}
		
			if($empresa["costoModuloImpuestos"] == 0)
			{
				$empresa["costoModuloImpuestos"] = COSTO_IMPUESTOS;
			}
			
			$subtotal = $empresa["costo"];
			
			if($empresa["moduloImpuestos"] == "Si")
			{
				$subtotal += $empresa["costoModuloImpuestos"];
			}
		
			if($empresa["moduloNomina"] == "Si")
			{
				$subtotal += $empresa["costoModuloNomina"];
			}
			
			$iva = $subtotal * IVA;
			$total = $subtotal + $iva;
			
			$result[$key]["subtotal"] = $subtotal;
			$result[$key]["iva"] = $iva;
			$result[$key]["total"] = $total;
			
			if($empresa["tipoSocio"] == "proveedor")
			{
				unset($result[$key]);
				continue;
			}

			$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM empresa WHERE empresaId = '".$empresa["socioId"]."'");
			$countSocioId = $this->Util()->DB()->GetSingle();

			if($countSocioId)
			{
				$this->Util()->DBSelect($empresa["socioId"])->setQuery("SELECT * FROM ".DB_PREFIX.$empresa["socioId"].".rfc LIMIT 1");
				$result[$key]["socio"] = $this->Util()->DBSelect($empresa["socioId"])->GetRow(); 
				
				$sql="select nombre from usuarios where idUsuario='".$empresa["socioId"]."'";
				$this->Util()->DB()->setQuery($sql);
				$result[$key]["socio"]["razonSocial1"] = $this->Util()->DB()->GetSingle();
			}
			else
			{  
				$sql="select nombre from usuarios where idUsuario='".$empresa["socioId"]."'";
				$this->Util()->DB()->setQuery($sql);
				$result[$key]["socio"]["razonSocial1"] = $this->Util()->DB()->GetSingle();
				$result[$key]["socio"]["razonSocial"] = "Facturasexxxx";
			}
			$result[$key]["socio"]["razonSocial"] = utf8_decode($result[$key]["socio"]["razonSocial"]);

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT * FROM ".DB_PREFIX.$empresa["empresaId"].".rfc LIMIT 1");
			$result[$key]["rfc"] = $this->Util()->DBSelect($empresa["empresaId"])->GetRow();
			
			$result[$key]["rfc"]["razonSocial"] = utf8_decode(urldecode($result[$key]["rfc"]["razonSocial"]));
			$result[$key]["rfc"]["localidad"] = utf8_decode(urldecode($result[$key]["rfc"]["localidad"]));
			
//			$result[$key]["rfc"]["razonSocial"] = urldecode($result[$key]["rfc"]["razonSocial"]);
			$versionF=$result[$key]["version"];
			switch($result[$key]["version"])
			{
				case 2: $result[$key]["version"] = "Medios Propios";break;
				case "v3": $result[$key]["version"] = "Empresarial";break;
				case "auto": $result[$key]["version"] = "CBB";break;
				case "ticgums": $result[$key]["version"] = "Medios Propios";break;
				case "avantika": $result[$key]["version"] = "Medios Propios";break;
				case "construc": $result[$key]["version"] = "Corporativo";break;
				case "demo": $result[$key]["version"] = "PAC";break;
				case "global": $result[$key]["version"] = "PAC";break;
			}

			//facturas expedidas 
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM ".DB_PREFIX.$empresa["empresaId"].".comprobante WHERE empresaId = ".$empresa["empresaId"]." LIMIT 1");			
			$result[$key]["expedidos"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();

			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT fecha FROM ".DB_PREFIX.$empresa["empresaId"].".comprobante ORDER BY fecha DESC LIMIT 1");			
			$result[$key]["ultimaExpedida"] = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();
			
			if($_POST["sinFacturar"])
			{
				$ultima = strtotime($result[$key]["ultimaExpedida"]);
				$time = time() - (3600 * 24 * 365);
				if($ultima > $time)
				{
					unset($result[$key]);
					continue;
				}
			}
			
			$dateExploded = explode("-", $result[$key]["vencimiento"]);
			$result[$key]["vencimientoStamp"] = strtotime($result[$key]["vencimiento"]);
			
			if($result[$key]["vencimientoStamp"] < time())
			{
				$result[$key]["statusServicio"] = "Expirado";
			}
			elseif($result[$key]["vencimientoStamp"] < time() + 3600 * 24 *30)
			{
				$result[$key]["statusServicio"] = "PorExpirar";
			}
			
			$ven=$result[$key]["vencimiento"];
		   $mes1=$dateExploded[1];
			
			$result[$key]["vencimiento"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];
			//$result[$key]["vencimiento"] = $dateExploded[1];

			$dateExploded = explode("-", $result[$key]["activadoEl"]);
			$result[$key]["activadoEl"] = $dateExploded[2]."-".$months[$dateExploded[1]]."-".$dateExploded[0];
			
			$result[$key]["terminar"] = 0;
 			if($result[$key]["limite"] - $result[$key]["expedidos"] < 20 && $result[$key]["limite"] > 10)
			{
				$result[$key]["terminar"] = 1;
			}

			if($_POST["limite"])
			{
	 			if($result[$key]["limite"] - $result[$key]["expedidos"] > 20 || $result[$key]["limite"] <= 10 || $result[$key]["limite"] == 0)
				{ 
					unset($result[$key]);
					continue;
				}
			}

			if($_POST["conTimbres"])
			{
				//timbres activados
	 			if($result[$key]["limite"] <= 10 || 
					($result[$key]["limite"] > 10 && !$result[$key]["statusServicio"]))
				{ 
					unset($result[$key]);
					continue;
				}
			}
			
			//echo $result[$key]["rfc"]["razonSocial"];
			//echo $result[$key]["statusServicio"]; echo "a ";
			if($_POST["sinTimbres"])
			{
				//timbres activados
	 			if(
					$result[$key]["limite"] > 10 || 
					$result[$key]["limite"] == 0 ||
					($result[$key]["limite"] <= 10 && $result[$key]["statusServicio"])
				)
				{ 
					unset($result[$key]);
					continue;
				}
			}
			

			 //Agregado por jesus
			 $this->Util()->DB()->setQuery('SELECT MAX(date) FROM log WHERE empresaId = "'.$empresa["empresaId"].'"');
				//print_r( $this->Util()->DB()->query);
				$ultimolog = $this->Util()->DB()->GetSingle();
				
				
				
				$semana = date("Y-m-d", strtotime('-1 week'));
				$mes = date("Y-m-d", strtotime('-1 month'));
				$ultimo = date("Y-m-d", strtotime($ultimolog));
				$result[$key]["ultimolog"] =$ultimo;
				if ($ultimo > $semana) 
						{
							$result[$key]["statusLog"] = "semana";
						} 
					else{
							if ($ultimo > $mes ) 
								{
								$result[$key]["statusLog"] = "mes";
								} 
							else 
								{
								$result[$key]["statusLog"] = "mayor";
								}
						}
				
				$nuevaFecha= date('Y-m-d', strtotime('+1 month')) ;		
			//$versionF
		        	 switch($mes1)
					 {
			             case "01":
						      if($this->mes=="1" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											   if($this->version=="todos"){
													array_push($meses['Enero'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Enero'],$result[$key]);
												 }
										
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
															if($this->version=="todos"){
																	array_push($meses['Enero'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Enero'],$result[$key]);
															}
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Enero'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Enero'],$result[$key]);
															}
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
													if($this->version=="todos"){
																	array_push($meses['Enero'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Enero'],$result[$key]);
															}
											  }
										
										}
								}
                         break;
						 case "02":
							if($this->mes=="2" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Febrero'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Febrero'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Febrero'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Febrero'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Febrero'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Febrero'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Febrero'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Febrero'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "03":
						 if($this->mes=="3" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Marzo'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Marzo'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Marzo'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Marzo'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Marzo'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Marzo'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Marzo'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Marzo'],$result[$key]);
															}
											  }
										
										}
								}
								
						 break;
						 case "04":
							if($this->mes=="4" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Abril'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Abril'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Abril'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Abril'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Abril'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Abril'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Abril'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Abril'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "05":
							if($this->mes=="5" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Mayo'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Mayo'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Mayo'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Mayo'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Mayo'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Mayo'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Mayo'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Mayo'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "06":
							if($this->mes=="6" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Junio'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Junio'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Junio'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Junio'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Junio'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Junio'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Junio'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Junio'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "07":
							if($this->mes=="7" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Julio'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Julio'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Julio'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Julio'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Julio'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Julio'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Julio'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Julio'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "08":
							if($this->mes=="8" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Agosto'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Agosto'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Agosto'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Agosto'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Agosto'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Agosto'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Agosto'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Agosto'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "09":
						if($this->mes=="9" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Septiembre'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Septiembre'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Septiembre'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Septiembre'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Septiembre'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Septiembre'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Septiembre'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Septiembre'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "10":
							if($this->mes=="10" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Octubre'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Octubre'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Octubre'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Octubre'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Octubre'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Octubre'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Octubre'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Octubre'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "11":
							if($this->mes=="11" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Noviembre'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Noviembre'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Noviembre'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Noviembre'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Noviembre'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Noviembre'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Noviembre'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Noviembre'],$result[$key]);
															}
											  }
										
										}
								}
						 break;
						 case "12":
							if($this->mes=="12" || $this->mes=="todos"){
									  if($this->vencimiento=="todos"){
											if($this->version=="todos"){
													array_push($meses['Diciembre'],$result[$key]);
										         }else if($this->version==$versionF){
													array_push($meses['Diciembre'],$result[$key]);
												 }
										}else if($this->vencimiento=="vencido"){
										     if($ven<date("Y-m-d")){
														if($this->version=="todos"){
																	array_push($meses['Diciembre'],$result[$key]);
														 }else if($this->version==$versionF){
																	array_push($meses['Diciembre'],$result[$key]);
														 }
											 }
										}else if($this->vencimiento=="novencido"){
											 if($ven>=date("Y-m-d")){
														if($this->version=="todos"){
																array_push($meses['Diciembre'],$result[$key]);
														 }else if($this->version==$versionF){
																array_push($meses['Diciembre'],$result[$key]);
														 }
												 }
										}else if($this->vencimiento=="porvencer"){
										      if($ven>=date("Y-m-d") && $ven<=$nuevaFecha){
															if($this->version=="todos"){
																	array_push($meses['Diciembre'],$result[$key]);
															}else if($this->version==$versionF){
																	array_push($meses['Diciembre'],$result[$key]);
															}
											  }
										
										}
								}
						 break;  						 
					 
					 }
					 
					
		}// end foreach result 
		
		if($_GET["orderBy"]=='ultimo'){
				$this->aasort($result,"statusLog");
				
		}
//echo "<pre>";
	//	print_r($meses);
		//exit;
		//print_r($result);
		return $meses;
	
	}
	
	
	public function aasort(&$array, $key) {
    		$sorter=array();
    		$ret=array();
    		reset($array);
    			foreach ($array as $ii => $va) {
        			$sorter[$ii]=$va[$key];
    			}
    
			arsort($sorter);
    			foreach ($sorter as $ii => $va) {
        			$ret[$ii]=$array[$ii];
    			}
    		$array=$ret;
		}
		
		
		

	public function FiltroTipo()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE version LIKE "%'.$this->tipo.'%" ORDER BY empresaId ASC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}
	
	public function CancelarOrden()
	{
		
		$data = $this->DataEmpresa();
		if ($data == 0)
		{
			$valor = 1;
			$this->Util()->setError(20004, "complete");
		}
		elseif ($data == 1)
		{
			$valor = 0;
			$this->Util()->setError(20005, "complete");
		}
		else
		{
			return false;
		}
			$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`activo` = '".$valor."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function CambiarEstatus()
	{
			$this->Util()->DB()->setQuery("
				SELECT activo FROM 
					empresa
				WHERE empresaId = '".$this->id."'");
		$status = $this->Util()->DB()->GetSingle();
		
		if($status == "1")
		{
			$status = 0;
		}
		else
		{
			$status = 1;
		}
		
			$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`activo` = '".$status."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		$this->Util()->PrintErrors();
		return true;
	}	
	
	public function CambiarInterno()
	{
			$this->Util()->DB()->setQuery("
				SELECT interno FROM 
					empresa
				WHERE empresaId = '".$this->id."'");
		$status = $this->Util()->DB()->GetSingle();
		
		if($status == "Si")
		{
			$status = "No";
		}
		else
		{
			$status = "Si";
		}
		
			$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`interno` = '".$status."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		$this->Util()->PrintErrors();
		return true;
	}		
	
	public function BorrarEmpresa()
	{
			$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`borrar` = 'Si'
				WHERE empresaId = '".$this->id."'");
				echo $this->Util()->DB()->query;
		$this->Util()->DB()->UpdateData();
		$this->Util()->PrintErrors();
		return true;
	}	
	
	public function DataEmpresa()
	{
		$this->Util()->DB()->setQuery('SELECT activo FROM empresa WHERE empresaId = "'.$this->id.'"');
		$result = $this->Util()->DB()->GetSingle();
		return $result;
	}
	
	public function Log()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM log WHERE empresaId = "'.$this->id.'" ORDER BY date DESC');
		$result = $this->Util()->DB()->GetResult();
		return $result;
	
	}

		
	public function Data()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM empresa WHERE empresaId = "'.$this->id.'"');
		$result = $this->Util()->DB()->GetRow();
		return $result;
	}

	public function AddLog()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$data = $this->Data();
		
		$fecha = date("Y-m-d H:i:s");
		
		$this->Util()->DB()->setQuery("
			INSERT INTO
				log
			(
				`comment`,
				`date`,
				`empresaId`
		)
		VALUES
		(
				'".$this->status."',
				'".$fecha."',
				'".$this->id."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20006, "complete", "Has agregado un log");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function AddFolios()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$data = $this->Data();
		$this->Util()->DB()->setQuery("
				UPDATE
					empresa
				SET
				`limite` = `limite` +'".$this->cantidad."'
				WHERE empresaId = '".$this->id."'");
		$this->Util()->DB()->UpdateData();
		
		$fecha = date("Y-m-d");
		
		$this->Util()->DB()->setQuery("
			INSERT INTO
				ventas
			(
				`cantidad`,
				`fecha`,
				`idSocio`,
				`idEmpresa`,
				`status`
		)
		VALUES
		(
				'".$this->cantidad."',
				'".$fecha."',
				'".$data['socioId']."',
				'".$data['empresaId']."',
				'".$this->status."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20006, "complete");
		$this->Util()->PrintErrors();
		return true;
	}	
}
?>