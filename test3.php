<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

			$db->setQuery("SELECT * FROM empresa WHERE empresaId < 1000");
			$empresas = $db->GetResult();
						
			foreach($empresas as $empresa)
			{
				if(!file_exists(DOC_ROOT."/empresas/".$empresa["empresaId"]))
				{
					echo $empresa["empresaId"];
					echo "<br>";
				}
			}
			
