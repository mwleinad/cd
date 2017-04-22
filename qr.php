<?php
date_default_timezone_set('America/Los_Angeles');

//include only that one, rest required files will be included from it
include_once("libs/qr/qrlib.php");

//write code into file, Error corection lecer is lowest, L (one form: L,M,Q,H)
//each code square will be 4x4 pixels (4x zoom)
//code will have 2 code squares white boundary around 

$cadenaCodigoBarras = "?re=LOAD850511SX3&rr=LOAD850511SX3&tt=0000000123.123456&id=ad662d33-6934-459c-a128-BDf0393f0f44";
QRcode::png($cadenaCodigoBarras, 'test.png', 'L', 4, 2);

echo '<img src="'.$PNG_WEB_DIR.basename("test.png").'" /><hr/>';  


$tab = QRCode::encode('PHP QR Code :)');
QRspec::debug($tab, true);

?>