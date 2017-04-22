<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "./templates/forms/ordenesFiltro1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:96861503456c8a88037b664-95011706%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3833e07843c5297f01a6c9598182a410db495b4f' => 
    array (
      0 => './templates/forms/ordenesFiltro1.tpl',
      1 => 1455433642,
    ),
  ),
  'nocache_hash' => '96861503456c8a88037b664-95011706',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divForm">
	<form id="filtro" name="filtro" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:10%;float:left">B&uacute;squeda:</div>
       Mes <select name="mes" id="mes">
        <option value="todos">Todos</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
        
        
      </select>
	  Status 	<select id="vencimiento" name="vencimiento">
		<option value="todos">Todos</option>
		<option value="vencido">Vencidos</option>
		<option value="novencido">No Vencidos</option>
		<option value="porvencer">Por Vencer</option>
		</select>
	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?>
		Versi&oacute;n <select id="version" name="version">
		<option value="todos">Todos</option>
		<option value="v3">Empresarial</option>
		<option value="auto">CBB</option>
		<option value="construc">Coorporativo</option>
		</select>
	<?php }?>
	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> Socio 	<select id="socioId" name="socioId">
		<option value="0">Todos</option>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('socios')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
			<option value="<?php echo $_smarty_tpl->getVariable('item')->value['idUsuario'];?>
"> <?php echo $_smarty_tpl->getVariable('item')->value['nombre'];?>
</option>
		<?php }} ?>
		
	</select>
  <?php }?>

	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> 
  	<br />Sin Facturar Mas de 2 Meses <input type="checkbox" name="sinFacturar" id="sinFacturar" value="1" />
  <?php }?>
		
	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> 
  	Timbres por Terminar <input type="checkbox" name="limite" id="limite" value="1" />
  <?php }?>

	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> 
  	Con Timbres sin Activar <input type="checkbox" name="conTimbres" id="conTimbres" value="1" />
  <?php }?>

	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> 
  	Activados sin Timbres <input type="checkbox" name="sinTimbres" id="sinTimbres" value="1" />
  <?php }?>

	<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?> 
  	Inactivos <input type="checkbox" name="inactivos" id="inactivos" value="1" />
  <?php }?>
    
        <input type="button" id="botonFiltro" name="botonFiltro" class="buttonForm1" value="Buscar" />

			</div>
			<div style="clear:both"></div>
			<input type="hidden" id="type" name="type" value="filtro_busqueda"/><br/>
			<div id="loading" style="display:none"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/loading.gif"> Cargando...</div>
		</fieldset>
	</form>
<br /><br />  

</div>


