<?php
$empresa->hasPermission($_GET['page']);
$impuesto->SetPage($_GET["p"]);
$resImpuesto = $impuesto->Enumerate();
$smarty->assign("resImpuesto", $resImpuesto);
?>