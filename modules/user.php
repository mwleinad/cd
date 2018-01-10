<?php
$info = $empresa->Info();
$smarty->assign("info", $info);

//print_r($info);
//print_r($_SESSION);
if($info)
{
	$rfc->setEmpresaId($_SESSION["empresaId"], 1);
	$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());
	
	$rfc->setEmpresaId($_SESSION['empresaId'], 1);
	$id_rfc = $rfc->getRfcActive();
	$rfc->setRfcId($id_rfc);
	$ruta_dir = DOC_ROOT.'/empresas/'.$_SESSION['empresaId'].'/certificados/'.$id_rfc;
	$certNuevo = $rfc->GetCertificadoByRfc();
	if($certNuevo){
		$expire = exec('openssl x509 -noout -in '.$ruta_dir.'/'.$certNuevo.'.cer.pem -dates');
		$exp = explode('=',$expire);
		$fecha_expiracion = $exp[1];

		//$fecha_expiracion = "Sep  15 15:04:26 2013";
		$fecha_exp = strtotime($fecha_expiracion);
		
		if($fecha_exp < time() + (ALERT_CERT * 24 * 3600))
		{
			$certAboutToExpire = "Sello Digital Proximo a Expirar <a href='".WEB_ROOT."/admin-folios/actualizar-certificado'>Actualizar?</a>";
			$smarty->assign("certAboutToExpire", $certAboutToExpire);
		}
//		$smarty->assign('fecha_expiracion', $fecha_exp);
	}//if
	
}


?>