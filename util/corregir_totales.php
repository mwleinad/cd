<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$id = $_GET['idEmpresa'];
//We need to change the data type of total and subtotal to double
$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa WHERE empresaId = ".$id);
$result = $db->GetResult();

$count = 1;
?>
<?php
$total = 0;
foreach($result as $key => $res)
{
    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `comprobante` CHANGE `subTotal` `subTotal` DECIMAL(20,6) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();

    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `comprobante` CHANGE `total` `total` DECIMAL(20,6) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();

    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `comprobante` CHANGE `descuento` `descuento` DECIMAL(20,6) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();

    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `notaVenta` CHANGE `subtotal` `subtotal` DECIMAL(20,2) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();

    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `notaVenta` CHANGE `total` `total` DECIMAL(20,2) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();

    $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE `payment` CHANGE `amount` `amount` DECIMAL(20,2) NOT NULL;");
    $util->DBSelect($res["empresaId"])->ExecuteQuery();


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
        $total = $xmlData['cfdi']['Total'];

        //if($total != $row['total']) {
            //echo $subtotal;
            $diff += $subtotal - $row['subTotal'];
            $util->DBSelect($_SESSION['empresaId'])->setQuery("UPDATE comprobante SET subTotal = ".$subtotal.", total = ".$total." WHERE comprobanteId = ".$row['comprobanteId']);
            $util->DBSelect($_SESSION['empresaId'])->UpdateData();

            $util->DBSelect($_SESSION['empresaId'])->setQuery("UPDATE notaVenta SET subtotal = ".$subtotal.", total = ".$total." WHERE comprobanteId = ".$row['comprobanteId']);
            //echo $util->DBSelect($_SESSION['empresaId'])->query;
            $util->DBSelect($_SESSION['empresaId'])->UpdateData();

        //}


    }
}
echo $diff;

