<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//ruta al archivo XML del CFDI
$root = $_SERVER['DOCUMENT_ROOT'];
$xmlFile= $root."/sistema/empresas/15/certificados/1/facturas/xml/15_A_95.xml";

// Ruta al archivo XSLT
$xslFile = $root."/sistema/xslt/cadenaoriginal_3_2.xslt";

echo $command = "xsltproc ".$xslFile." ".$xmlFile;
exit;
exec($command, $output, $return_var);

print_r($output);
print_r($return_var);

/*$myFile = $root."/md5sha1.txt";
$fh = fopen($myFile, 'r');
$theData = fread($fh, filesize($myFile));
fclose($fh);*/
?>