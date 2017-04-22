<?php
$empresa->AuthUser();
$empresa->hasPermission($_GET['page']);

$info = $empresa->Info();
$smarty->assign("info", $info);

$empresa->Util()->DB()->setQuery("SELECT * FROM usuario");
$result = $empresa->Util()->DB->GetResult();

$rfc->setEmpresaId($_SESSION["empresaId"], 1);
$smarty->assign("empresaRfcs", $rfc->GetRfcsByEmpresa());


$meses[1] = "Enero";
$meses[2] = "Febrero";
$meses[3] = "Marzo";
$meses[4] = "Abril";
$meses[5] = "Mayo";
$meses[6] = "Junio";
$meses[7] = "Julio";
$meses[8] = "Agosto";
$meses[9] = "Septiembre";
$meses[10] = "Octubre";
$meses[11] = "Noviembre";
$meses[12] = "Diciembre";
$smarty->assign("meses", $meses);

for($ii = MIN_YEAR; $ii <= MAX_YEAR; $ii++)
{
	$anios[$ii] = $ii;
}

$prevMes = date("n")-1;
$anio = date("Y");

if($prevMes == 0)
{
	$prevMes = 12;
	$anio--;
}

$smarty->assign("prevMes", $prevMes);
$smarty->assign("anios", $anios);
$smarty->assign("thisAnio", $anio);

?>