<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa WHERE empresaId = 561");
$result = $db->GetResult();

$count = 1;
?>
<?php
$total = 0;
foreach($result as $key => $res)
{
    $_SESSION['empresaId'] = $res["empresaId"];
    $util->DBSelect($res["empresaId"])->setQuery("SELECT comprobanteId, noCertificado, xml, rfc, comprobante.version, total, subTotal FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId 
			WHERE comprobante.version = '3.3'");
    $facturas = $util->DBSelect($res["empresaId"])->GetResult();

    $diff = 0;
    foreach($facturas as $row)
    {
        $xml = $row["xml"];

        $rfcActivo = $rfc->getRfcActive();
        $root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/SIGN_".$xml.".xml";

        $xmlData = $xmlReaderService->execute($root, $_SESSION['empresaId']);
        $subtotal = $xmlData['cfdi']['SubTotal'];

        if($subtotal != $row['subTotal']) {
            echo "diff";
            echo PHP_EOL;
            //echo $subtotal;
            $diff += $subtotal - $row['subTotal'];
            $util->DBSelect($_SESSION['empresaId'])->setQuery("UPDATE comprobante SET subTotal = ".$subtotal." WHERE comprobanteId = ".$row['comprobanteId']);
            $util->DBSelect($_SESSION['empresaId'])->UpdateData();
        }


    }
}
echo $diff;

