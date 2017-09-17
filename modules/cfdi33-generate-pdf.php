<?php
$empresa->AuthUser();

$info = $empresa->Info();
$smarty->assign("info", $info);

if(!$_GET['filename']) {
    exit;
}

$pdfService->generate($info["empresaId"], $_GET['filename'], $_GET['download']);