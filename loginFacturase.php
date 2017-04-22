<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

			$db->setQuery("SELECT * FROM usuario WHERE empresaId = '".$_GET["id"]."' AND type = 'admin' ORDER BY usuarioId ASC LIMIT 1");
			$usuario = $db->GetRow();
						
			$empresa->DoLogout();
			
			$empresa->setEmailLogin($usuario["email"]);
			$empresa->setPassword($usuario["password"]);

			$empresa->DoLogin();
			
			header("Location:sistema");

exit;