<?php

$orden->SetPage($_GET["p"]);
$resOrden = $orden->Enumerate();

//echo "<pre>";print_r($_SESSION);EXIT;

$smarty->assign("resOrden", $resOrden);
?>