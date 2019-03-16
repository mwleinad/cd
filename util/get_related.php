<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

//We need to change the data type of total and subtotal to double
$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa WHERE empresaId = 1137");
$result = $db->GetRow();

print_r($result);

$pac = new Pac;

//Get password
$root = DOC_ROOT."/empresas/".$result["empresaId"]."/certificados/1/password.txt";
$fh = fopen($root, 'r');
$password = fread($fh, filesize($root));

fclose($fh);

if(!$password)
{
    return false;
}

$_SESSION["empresaId"] = $result['empresaId'];
//$this->setRfcId($rfcActivo);
$response = $pac->GetRelated($user, $pw, $result["rfc"], 'BCA8AD80-0F58-4BCB-A2B9-41F1B9447702', $path, $password, false, $id_comprobante, 'ETE070809JP7');