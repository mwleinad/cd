<?php /* Smarty version Smarty3-b7, created on 2016-03-03 14:26:45
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/edit-impuestos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:192657970856d8ba255b9609-96966603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5164c07858e71878b3ba8b09617edb50f7761e47' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/edit-impuestos.tpl',
      1 => 1455433636,
    ),
  ),
  'nocache_hash' => '192657970856d8ba255b9609-96966603',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divForm">
	<form id="editVentasForm" name="editVentasForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Status:</div>
       <select  name="status" id="status">
       <option value="pagado">Activo</option>
       <option value="noPagado">No Activo</option>
       <option value="cancelado">Cancelado</option>
      
       </select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editVentas" name="editVentas" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditVentas"/>
			<input type="hidden" id="idVenta" name="idVenta" value="<?php echo $_smarty_tpl->getVariable('post')->value['idVenta'];?>
"/>
		</fieldset>
	</form>
</div>
