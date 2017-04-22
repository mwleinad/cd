<?php /* Smarty version Smarty3-b7, created on 2016-02-27 12:50:17
         compiled from "templates/reporte-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:131034139456d20c09d14973-65355264%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a9eee6b5cd195f04fefcb470651f4ad7aa8e4b2' => 
    array (
      0 => 'templates/reporte-new.tpl',
      1 => 1456606215,
    ),
  ),
  'nocache_hash' => '131034139456d20c09d14973-65355264',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="center">
	<span id="addReporte" style="cursor:pointer">Nota: El historial de ingresos por modulo de nomina o impuestos se empezaron a capturar el 24 de Noviembre del 2015 por lo que no se ven reflejados</span>
</div>
<div id="content">
  <table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
    	<tr>
	      <td>A&ntilde;o</td>
	      <td>Mes</td>
	      <td># Ventas Folios Braun</td>
	      <td>Total Folios Vendidos Braun</td>
	      <td>Ingreso por Venta de Folios Braun</td>
	      <td># Ventas Folios Braun Interno</td>
	      <td>Total Folios Vendidos Braun Interno</td>
	      <td>Ingreso por Venta de Folios Braun Interno</td>
	      <td># Ventas Folios</td>
	      <td>Total Folios Vendidos</td>
	      <td>Ingreso por Venta de Folios</td>
	      <td>Nominas Renovadas</td>
	      <td>Ingresos por modulos de nomina</td>
	      <td>Impuestos Renovados</td>
	      <td>Ingreso por Impuestos</td>
	      <td>Ingreso Total</td>
      </tr>

  <?php  $_smarty_tpl->tpl_vars['year'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resReporte')->value['years']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['year']->key => $_smarty_tpl->tpl_vars['year']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['year']->key;
?>
  	<?php  $_smarty_tpl->tpl_vars['month'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['keyMonth'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('year')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value){
 $_smarty_tpl->tpl_vars['keyMonth']->value = $_smarty_tpl->tpl_vars['month']->key;
?>
    	<tr>
	      <td><?php echo $_smarty_tpl->getVariable('key')->value;?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['mes'];?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['noVentasBraun'];?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['foliosBraun'];?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoPorFoliosBraun'],2);?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['noVentasBraunInterno'];?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['foliosBraunInterno'];?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoPorFoliosBraunInterno'],2);?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['noVentas'];?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['folios'];?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoPorFolios'],2);?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['noNominas'];?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoPorNomina'],2);?>
</td>
	      <td><?php echo $_smarty_tpl->getVariable('month')->value['noImpuestos'];?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoPorImpuestos'],2);?>
</td>
	      <td>$<?php echo number_format($_smarty_tpl->getVariable('month')->value['ingresoTotal'],2);?>
</td>
      </tr>
    <?php }} ?>
  <?php }} ?>
  </table>
  Promedio ingresos mensuales: <?php echo $_smarty_tpl->getVariable('resReporte')->value['promedio'];?>

</div>
