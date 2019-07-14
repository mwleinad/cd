<?php

define("DOC_ROOT", '/var/www/html/sistema');

include_once(DOC_ROOT.'/init.php');
include_once(DOC_ROOT.'/config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT * FROM vin_cfdi_cancel WHERE (status = 'pending' OR status = 'Pending')");
$result = $db->GetResult();

echo "Pending: ".count($result);

foreach($result as $key => $row) {
    $_SESSION['empresaId'] = $row["org_id"];

    $util->DBSelect($_SESSION['empresaId'])->setQuery("SELECT xml FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId 
			WHERE comprobanteId = ".$row['cfdi_id']);
    $xml = $util->DBSelect($_SESSION['empresaId'])->GetSingle();

    $rfcActivo = $rfc->getRfcActive();
    $root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/SIGN_".$xml.".xml";

    $xmlData = $xmlReaderService->execute($root, $_SESSION['empresaId']);
    $total = (string) $xmlData['cfdi']['Total'];

    $response = $cancelation->getStatus($row['org_id'], $row['taxpayer_id'], $row['rtaxpayer_id'], $row['uuid'], $total);
    print_r($row['solicitud_cancelacion_id']);
    print_r($response);

    $cancelation->processCancelation($row, $response);
}

echo "Process finished";