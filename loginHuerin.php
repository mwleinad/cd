<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

			$db->setQuery("SELECT empresaId FROM empresa WHERE rfc = '".$_GET["rfc"]."'");
			$empresaId = $db->GetSingle();

			$db->setQuery("SELECT * FROM usuario WHERE empresaId = '".$empresaId."' AND type = 'admin'");
			$usuario = $db->GetRow();
						
			$empresa->DoLogout();
			
			$empresa->setEmailLogin($usuario["email"]);
			$empresa->setPassword($usuario["password"]);

			$empresa->DoLogin();
			
			header("Location:sistema");

exit;