<?php

$contacto->SetPage($_GET["p"]);
$__contacto = $contacto->Enumerate();
$smarty->assign("__contacto", $__contacto);
?>