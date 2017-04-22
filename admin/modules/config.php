<?php

$__config = $config->Enumerate();
$smarty->assign("__config", $__config);

			$config->setIdConfig(1);

if($_POST["editConfig"])
{
			$config->setEmail($_POST['email']);
			$config->setHome($_POST['home']);
			$config->setNosotros($_POST['nosotros']);
			$config->setMision($_POST['mision']);
			$config->setVision($_POST['vision']);
			$config->setEventos($_POST['eventos']);
			$config->setValores($_POST['valores']);
			$config->setLaborSocial($_POST['laborSocial']);
			$config->setFormatos($_POST['formatos']);
			$config->setProducto($_POST['producto']);
			$config->setCompetencia($_POST['competencia']);
			$config->setBeneficios($_POST['beneficios']);
			$config->setFunciona($_POST['funciona']);
			$config->setPreguntas($_POST['preguntas']);			
			$config->setCarrusel($_POST['carrusel']);
			$config->setIdConfig(1);
			$config->Edit();
}

			$myConfig = $config->Info();
			$smarty->assign("post", $myConfig);

?>