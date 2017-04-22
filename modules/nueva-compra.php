<?php
	$empresa->AuthUser();
	//$empresa->hasPermission($_GET['page']);
	$excentoIva = $main->ListExcentoIva();
	$ivas = $main->ListIvas();
	
	
	if($_POST["action"] == "agregarXML" && $_FILES["xml"]["tmp_name"])
	{
		$rfc = new Rfc;
		$rfcActivo = $rfc->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
		$data = $xmlTransformCompra->Execute($ruta, $_FILES["xml"]["tmp_name"]);
		$destino = $root.$data["UUID"].".xml";
		$smarty->assign("data",$data);
		move_uploaded_file($_FILES["xml"]["tmp_name"], $destino); 
	}

	if($_POST["action"] == "Confirmar")
	{
		$rfc = new Rfc;
		$rfcActivo = $rfc->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
		$destino = $root.$_POST["uuid"].".xml";
		$data = $xmlTransformCompra->Execute($ruta, $destino);
		$compra = $compra->confirmar($data);
		
		$smarty->assign("compra",$compra);
	}


	
	
?>