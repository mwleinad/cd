<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$empresas = array(698);
$implode = implode(",", $empresas);

$db->setQuery("SELECT rfc, razonSocial, empresaId FROM empresa WHERE interno = 'Si'");
$result = $db->GetResult();

$count = 1;
?>
<table>
	<tr>
  	<td>
    #
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
foreach($result as $key => $res)
{?>
<?php
	
	$util->DBSelect($res["empresaId"])->setQuery("
		SELECT COUNT(*) FROM comprobante"
	);
	$expedidos = $util->DBSelect($res["empresaId"])->GetSingle();
	
?>
	<tr>
  	<td>
    <?php echo $count;?>
    </td>
  	<td>
    <?php echo $res["rfc"];?>
    </td>
  	<td>
    <?php echo $res["razonSocial"]?>
    </td>
  	<td>
    <?php echo $expedidos;?>
    </td>
  </tr>
<?php 	
	$count++;
}


?>