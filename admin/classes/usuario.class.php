<?php 

class Usuario extends Main
{
	private $idUsuario;
	private $username;
	public $nombre;
	private $password;
	private $pagosFaltantes;
	private $saldo;
	private $proximoPago;
	private $tipo;
	public $empresaId;
	public $precio;
	public $precioCliente;
	public $costoModuloImpuestos;
	public $costoModuloNomina;
	public $moduloNomina;
	public $moduloImpuestos;
	public $fechaVenc;
	public $limiteFolios;

	public function setModuloNomina($value){
	   $this->Util()->ValidateString($value, 10000, 1, 'Nomina');
	   $this->moduloNomina=$value;
	}

	public function setModuloImpuestos($value){
	   $this->Util()->ValidateString($value, 10000, 1, 'moduloImpuestos');
	   $this->moduloImpuestos=$value;
	}

	public function setCostoModuloImpuestos($value){
		//$this->Util()->ValidateFloat($value);
		$this->costoModuloImpuestos = $value;
	}

	public function setCostoModuloNomina($value){
		//$this->Util()->ValidateFloat($value);
		$this->costoModuloNomina = $value;
	}
	
	
	public function setPrecio($value){
		$this->Util()->ValidateFloat($value);
		$this->precio=$value;
	}
	
	public function setPrecioCliente($value){
	$this->Util()->ValidateFloat($value);	
	$this->precioCliente=$value;
	}
	
	
	
	public function setNombre($value){
	   $this->Util()->ValidateString($value, 10000, 2, 'Nombres');
	   $this->nombre=$value;
	}
	

	public function setEmpresaId($value){
	$this->empresaId=$value;
	}

	public function setIdUsuario($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->idUsuario = $value;
	}

	public function getIdUsuario()
	{
		return $this->idUsuario;
	}

	public function setUsername($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'username');
		$this->username = $value;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setPassword($value)
	{
		$this->Util()->ValidateString($value, 10000, 1, 'password');
		$this->password = $value;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setTipo($value)
	{
		$this->tipo = $value;
	}

	public function getTipo()
	{
		return $this->tipo;
	}
	
	public function setFechaVenc($value){
	   $this->Util()->ValidateString($value, 10000, 1, 'Fecha de Vencimiento');
	   $this->fechaVenc = $value;
	}
	
	public function setLimiteFolios($value){
	   $this->Util()->ValidateString($value, 10000, 1, 'Limite de Folios');
	   $this->Util()->ValidateInteger($value);
	   $this->limiteFolios = $value;
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

	public function Enumerate()
	{
		$this->Util()->DB()->setQuery('SELECT * FROM usuarios ORDER BY idUsuario ASC');
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
	
	

	public function Info()
	{
		if(!$this->idUsuario)
		{
			$this->idUsuario = $_SESSION["loginKey"];
		}
		$this->Util()->DB()->setQuery("SELECT * FROM usuarios WHERE idUsuario = '".$this->idUsuario."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
	}

	public function Edit()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			UPDATE
				usuarios
			SET
			`nombre` = '".$this->nombre."',
			`username` = '".$this->username."',
				`password` = '".$this->password."',
				`tipo` = '".$this->tipo."'
			WHERE idUsuario = '".$this->idUsuario."'");
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function SaveChangeSocio(){
	
	if($this->Util()->PrintErrors()){ return false; }
        $sql="
			UPDATE
				empresa
			SET
			 	`socioId` = '".$this->idUsuario."'
			WHERE empresaId = '".$this->empresaId."'";
			
			//print_r($sql);exit;
		$this->Util()->DB()->setQuery($sql);
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	
	}
	
		public function SaveChangePrice(){
	
	if($this->Util()->PrintErrors()){ return false; }
        $sql="
			SELECT venImpuestos, moduloImpuestos, moduloNomina, venNomina FROM empresa WHERE 
			 empresaId = '".$this->empresaId."'";

		$this->Util()->DB()->setQuery($sql);
		$oldData = $this->Util()->DB()->GetRow();

        $sql="
			UPDATE
				empresa
			SET
			 	`venImpuestos` = '".$this->Util()->FormatDateMySql($this->costoModuloImpuestos)."',
			 	`moduloImpuestos` = '".$this->moduloImpuestos."',
			 	`moduloNomina` = '".$this->moduloNomina."',
			 	`venNomina` = '".$this->Util()->FormatDateMySql($this->costoModuloNomina)."'
			WHERE empresaId = '".$this->empresaId."'";
			
			//print_r($sql);exit;
		$this->Util()->DB()->setQuery($sql);
		$this->Util()->DB()->UpdateData();
		
		
		$sql2 = "INSERT INTO  `modulo` (
			`venImpuestos` ,
			`moduloImpuestos` ,
			`moduloNomina` ,
			`venNomina` ,
			`venImpuestosOld` ,
			`moduloImpuestosOld` ,
			`moduloNominaOld` ,
			`venNominaOld` ,
			`empresaId`
			)
			VALUES (
			'".$this->Util()->FormatDateMySql($this->costoModuloImpuestos)."',
			'".$this->moduloImpuestos."',
			'".$this->moduloNomina."',
			'".$this->Util()->FormatDateMySql($this->costoModuloNomina)."',
			'".$oldData["venImpuestos"]."',
			'".$oldData["moduloImpuestos"]."',
			'".$oldData["moduloNomina"]."',
			'".$oldData["venNomina"]."',
			'".$this->empresaId."');";
		$this->Util()->DB()->setQuery($sql2);
		$this->Util()->DB()->InsertData();


		$subject = 'Se actualizo modulo impuestos o nomina ';
		$body = "Para la empresa ".$this->idEmpresa.".\r\n";
		$body .= "Por el usuario ".$_SESSION["userName"].".\r\n";
		$body .= $sql;
		$sendMail = new SendMail;
		$sendMail->prepare($subject, $body);


		$this->Util()->setError(20001, "complete");
		$this->Util()->PrintErrors();
		return true;
	
	}
	
	
	public function Save()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO
				usuarios
			(
				`idUsuario`,
				`username`,
				`password`,
				`tipo`,
				`nombre`
		)
		VALUES
		(
				'".$this->idUsuario."',
				'".$this->username."',
				'".$this->password."',
				'".$this->tipo."',
				'".$this->nombre."'
		);");
		$this->Util()->DB()->InsertData();
		$this->Util()->setError(20003, "complete");
		$this->Util()->PrintErrors();
		return true;
	}

	public function Delete()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			DELETE FROM
				usuarios
			WHERE
				idUsuario = '".$this->idUsuario."'");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(20002, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	
	function DoLogin()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}

		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM usuarios WHERE username = '".$this->username."' AND password = '".$this->password."'");
		$rows = $this->Util()->DB()->GetSingle();
		if($rows == 0)
		{
			unset($_SESSION["loginKey"]);	
			$this->Util()->setError(10006, "error");
			if($this->Util()->PrintErrors()){ return false; }
		}
		$this->Util()->DB()->setQuery("SELECT * FROM usuarios WHERE username = '".$this->username."' AND password = '".$this->password."'");
		$usuarioInfo = $this->Util()->DB()->GetRow();
		//echo "<pre>";
		//print_r($usuarioInfo);
        
		$_SESSION["loginKey"] = $usuarioInfo['idUsuario'];	
		$_SESSION["tipo"] = $usuarioInfo['tipo'];	
		$_SESSION["userName"] = $usuarioInfo['username'];	
		if($usuarioInfo['tipo']=='admin'){
		$_SESSION["roleId"]=1;
		}else if($usuarioInfo['tipo']=='partner' || $usuarioInfo['tipo']=='partnerPro'){
		$_SESSION["roleId"]=2;
		}else if($usuarioInfo['tipo']=='comisionista'){
		$_SESSION["roleId"]=3;
		}
		
		return true;
	}

	function DoLogout()
	{
		unset($_SESSION["loginKey"]);	
	}

	function IsLoggedIn()
	{
		if($_SESSION["loginKey"])
		{
			$GLOBALS["smarty"]->assign('user', $this->Info());
			return true;
		}
		return false;
	}

	function AuthUser()
	{
		if(!$this->IsLoggedIn())
		{
			$this->Util()->LoadPage('homepage');
		}
	}

	function AuthAdmin()
	{
		if(!$this->IsLoggedIn())
		{
			$this->Util()->LoadPage('homepage');
		}
		$usuario = $this->Info();
		if($usuario["tipo"] != "admin" && $usuario["tipo"] != "partner" && $usuario["tipo"] != "comisionista")
		{
			$this->Util()->LoadPage('homepage');
		}
	
	
	}
	
	public function SaveFechaVenc(){
	
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$sql = 'UPDATE empresa SET vencimiento = "'.$this->fechaVenc.'", limite = "'.$this->limiteFolios.'"
				WHERE empresaId = "'.$this->empresaId.'"';		
		$this->Util()->DB()->setQuery($sql);
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(0, 'complete','Los datos fueron actualizados correctamente');
		$this->Util()->PrintErrors();
		
		return true;
		
	}//SaveFechaVenc


}

?>