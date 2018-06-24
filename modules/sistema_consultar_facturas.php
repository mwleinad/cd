<?php
			$empresa->hasPermission($_GET['section']);
			$comprobantes = array();
			$comprobante->SetPage($_GET["p"]);
			$result = $comprobante->GetComprobantesByRfc();
			if($result)
			{
				$comprobantes["items"] = $util->DecodeResult($result["items"]);
			}
			$comprobantes["pages"] = $result["pages"];
			
			$total = 0;
			$subtotal = 0;
			$iva = 0;
			$isr = 0;

			if(count($comprobantes["items"]) > 0){
				foreach($comprobantes["items"] as $res){


					if($res["status"] == 0)
					{
						continue;
					}
					if($res["tipoDeComprobante"] == "ingreso")
					{
						$total += $res['total'];
						$subtotal += $res['subTotal'];
						$iva += $res['ivaTotal'];
						$isr += $res['isrRet'];
						$payments += $res['payments_noformat'];
					}
					else
					{
						$total -= $res['total'];
						$subtotal -= $res['subTotal'];
						$iva -= $res['ivaTotal'];
						$isr -= $res['isrRet'];
						$payments -= $res['payments_noformat'];
					}
				}
			}

			$debt = number_format($total-$payments,2,'.',',');
			$payments = number_format($payments,2,'.',',');
			$total = number_format($total,2,'.',',');
			$subtotal = number_format($subtotal,2,'.',',');
			$iva = number_format($iva,2,'.',',');
			$isr = number_format($isr,2,'.',',');
				
			$smarty->assign('comprobantes',$comprobantes);
			$smarty->assign('total',$total);
			$smarty->assign('subtotal',$subtotal);
			$smarty->assign('iva',$iva);
			$smarty->assign('isr',$isr);
			$smarty->assign('payments',$payments);
			$smarty->assign('debt',$debt);
			
			for($k=1; $k<=12; $k++){
				$card['id'] = $k;
				$card['nombre'] = ucfirst($util->ConvertirMes($k));
				
				$meses[$k] = $card;
				
			}//for
			
			$smarty->assign('meses',$meses);
			$tipos_comprobantes = $main->ListTiposDeComprobantes();
			$smarty->assign('tipos_comprobantes',$tipos_comprobantes);
			$id_rfc = $sucursal->getRfcActive();
			$sucursal->setRfcId($id_rfc);
			$sucursales = $sucursal->GetSucursalesByRfc();
			$smarty->assign('sucursales',$sucursales);
?>	