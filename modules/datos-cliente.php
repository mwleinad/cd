<?php
$smarty->assign("DOC_ROOT", DOC_ROOT);
$cliente->setUserId($_SESSION['userId']);
$myCliente = $cliente->InfoCliente();
$smarty->assign("post", $myCliente);
?>