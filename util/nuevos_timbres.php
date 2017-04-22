<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$empresas = array(698);
$implode = implode(",", $empresas);

$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa");
$result = $db->GetResult();

$count = 1;
?>
<table>
	<tr>
  	<td>
    #
    </td>
  	<td>
    Id Empresa
    </td>
  	<td>
    Rfc
    </td>
  	<td>
    Razon Social
    </td>
  	<td>
    Expedidos
    </td>
  </tr>
<?php
$total = 0;
foreach($result as $key => $res)
{?>
<?php
	
	$util->DBSelect($res["empresaId"])->setQuery("
		SELECT COUNT(*) FROM comprobante WHERE fecha > '2016-02-19'"
	);
	$expedidos = $util->DBSelect($res["empresaId"])->GetSingle();
	$total += $expedidos;

	$util->DBSelect($res["empresaId"])->setQuery("
		SELECT rfc, razonSocial FROM rfc WHERE empresaId = '".$res["empresaId"]."'"
	);
	$empresa = $util->DBSelect($res["empresaId"])->GetRow();

	
?>
	<tr>
  	<td>
    <?php echo $count;?>
    </td>
  	<td>
    <?php echo $res["empresaId"];?>
    </td>
  	<td>
    <?php echo $empresa["rfc"]?>
    </td>
  	<td>
    <?php echo urldecode($empresa["razonSocial"])?>
    </td>
  	<td>
    <?php echo $expedidos;?>
    </td>
  </tr>
<?php 	
	$count++;
}
?>
</table>
<?php 
echo $total;


?>