<?php
/*		$db->setQuery('SELECT * FROM empresa 
				LEFT JOIN socio ON socio.socioId = empresa.socioId											
																	ORDER BY empresaId DESC');
		$result =$db->GetResult();
		foreach($result as $key => $empresa)
		{
			//facturas expedidas
			$util->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM comprobante LIMIT 1");			
			$expedidas = $expedidas + $util->DBSelect($empresa["empresaId"])->GetSingle();

			$util->DBSelect($empresa["empresaId"])->setQuery("SELECT razonSocial FROM rfc LIMIT 1");			
			$result[$key]["razonSocial"] = urldecode($util->DBSelect($empresa["empresaId"])->GetSingle());

		}

	$smarty->assign("expedidas", $expedidas);
	
	$smarty->assign("clientes", $result);
*/	
		

?>