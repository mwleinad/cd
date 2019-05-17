<?php

define("DOC_ROOT", '/var/www/html/sistema');

include_once(DOC_ROOT.'/init.php');
include_once(DOC_ROOT.'/config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT * FROM vin_cfdi_cancel WHERE status = 'pending'");
$result = $db->GetResult();

foreach($result as $key => $row) {
    $response = $cancelation->getStatus($row['org_id'], $row['taxpayer_id'], $row['rtaxpayer_id'], $row['uuid'], $row['total']);
    print_r($response);

    $cancelation->processCancelation($row, $response);
}