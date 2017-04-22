<?php
include_once('init.php');
include_once('config.php');
include_once('libraries.php');

$path = DOC_ROOT."/empresas/15/certificados/1/facturas/xml/";
$file = "15_A_230";
$xmlFile = $path.$file.".xml";
$zipFile = $path.$file.".zip";
$signedFile = $path.$file."_signed.zip";
$timbreFile = $path.$file."_timbre.zip";
$timbradoFile = $path."timbreCFDi.xml";

$util->Zip($path, $file);

echo "usuario:".$user = "user";
echo "<br>";
echo "password:".$pw = "pw";
echo "<br>";

$response = $pac->GetCfdi($user, $pw, $zipFile, $path, $signedFile);

$fileTimbreXml = $pac->GetTimbreCfdi($user, $pw, $zipFile, $path, $timbreFile);

$timbreXml = $pac->ParseTimbre($timbradoFile);

//print_r($timbreXml);
$cadenaOriginalTimbre = $pac->GenerateCadenaOriginalTimbre($timbreXml);
print_r($cadenaOriginalTimbre);
?>