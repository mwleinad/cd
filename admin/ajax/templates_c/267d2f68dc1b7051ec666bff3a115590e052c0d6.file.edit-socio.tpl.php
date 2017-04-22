<?php /* Smarty version Smarty3-b7, created on 2016-09-20 18:22:40
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/edit-socio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136125842057e1e0e0c41893-25411331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '267d2f68dc1b7051ec666bff3a115590e052c0d6' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/edit-socio.tpl',
      1 => 1455433638,
    ),
  ),
  'nocache_hash' => '136125842057e1e0e0c41893-25411331',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divForm">
	<form id="frmSocioEdit" name="frmSocioEdit" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Socio :</div>
       <select  name="socioId" id="socioId">
          <?php  $_smarty_tpl->tpl_vars['soc'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('listUsuarios')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['soc']->key => $_smarty_tpl->tpl_vars['soc']->value){
?>
		  <option value="<?php echo $_smarty_tpl->getVariable('soc')->value['idUsuario'];?>
" <?php if ($_smarty_tpl->getVariable('infoEmpresa')->value['socioId']==$_smarty_tpl->getVariable('soc')->value['idUsuario']){?> selected=selected <?php }?>> <?php echo $_smarty_tpl->getVariable('soc')->value['nombre'];?>
 </option>
          <?php }} ?>
       </select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editSocio" name="editSocio" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="changeSocioSave"/>
			<input type="hidden" id="empresaId" name="empresaId" value="<?php echo $_smarty_tpl->getVariable('empresaId')->value;?>
"/>
		</fieldset>
	</form>
</div>
