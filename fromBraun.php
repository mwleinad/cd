<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

echo "<pre>";
print_r($_POST);

			$productId = $_POST['productId'];
						
			$empresa->setEmail($_POST["rfc"]);
			$empresa->setPassword($_POST["password"]);
			$empresa->setProductId($productId);
			
			if($productId){
				if($productId == 'v3' || $productId == 'construc')
					$empresa->setFolios($_POST["folios"]);
			}			
			//checar si ya hay cuenta
			$db->setQuery("SELECT COUNT(*) FROM empresa WHERE rfc = '".$_POST["rfc"]."'");
			$count = $db->GetSingle();
			
			if($count > 0)
			{
				echo "Este RFC ya esta registrado. No Necesitas registrarlo de nuevo. Revisa tu seccion de Comprobante Digital para poder acceder a su cuenta";
				exit;
			}
			
			$empresa->setSocioId($_POST["socioId"]);
				$empresa->setNombre($_POST['nombre']);
				$empresa->setEmailPersonal($_POST['rfc']);
				$empresa->setTelPersonal($_POST['telefono']);
				$empresa->setCelular($_POST['celular']);
				$empresa->setRazonSocial($_POST["razonSocial"]);
				$empresa->setCalle($_POST["calle"]);
				$empresa->setNoInt($_POST["noInt"]);
				$empresa->setNoExt($_POST["noExt"]);
				$empresa->setColonia($_POST["colonia"]);
				$empresa->setLocalidad($_POST["localidad"]);
				$empresa->setMunicipio($_POST["municipio"]);
				$empresa->setCiudad($_POST["ciudad"]);
				$empresa->setCp($_POST["cp"]);
				$empresa->setEstado($_POST["estado"]);
				$empresa->setPais($_POST["pais"]);
				$empresa->setTelefono($_POST["telefono"]);
				$empresa->setRfc($_POST["rfc"]);
				$empresa->setRegimenFiscal($_POST["regimenFiscal"]);

			
				if(!$empresa->Register())
				{
					echo "Ocurrio un error al registrarlo. Anotar que cliente es y reportarlo a Daniel";
				}
				else
				{
					echo "La empresa fue registrada exitosamente";
				}
