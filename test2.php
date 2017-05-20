<?php
//TODO make it work with the v3.3
//http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ruta al archivo XML del CFDI
$root = $_SERVER['DOCUMENT_ROOT'];
$xmlFile= $root."/sistema/empresas/15/certificados/1/facturas/xml/15_A_96.xml";

// Ruta al archivo XSLT
$xslFile = $root."/sistema/xslt/cadenaoriginal_3_3.xslt";

// Crear un objeto DOMDocument para cargar el CFDI
$xml = new DOMDocument("1.0","UTF-8");
// Cargar el CFDI
$xml->load($xmlFile);

// Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
$xsl = new DOMDocument();
$xsl->load($xslFile);

// Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
$proc = new XSLTProcessor;
// Cargar las reglas de transformación desde el archivo XSLT.
$proc->importStyleSheet($xsl);
// Generar la cadena original y asignarla a una variable
$cadenaOriginal = $proc->transformToXML($xml);

$cadenaOriginal = trim($cadenaOriginal);

echo json_encode($cadenaOriginal);
echo str_replace("\n        |", "|", $cadenaOriginal);

?>