<?php
$empresa->AuthUser();

$info = $empresa->Info();
$smarty->assign("info", $info);

if(!$_GET['filename']) {
    echo "No hay nombre de archivo";
    print_r($_GET);
    exit;
}

$pdfService->generate($info["empresaId"], $_GET['filename'], $_GET['type']);