<?php /* Smarty version Smarty3-b7, created on 2016-06-25 14:50:14
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/usuario-base.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1715259555576efc9658d545-58406161%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21adfde8f2fad955085df00045fd74bf31678746' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/usuario-base.tpl',
      1 => 1455433656,
    ),
  ),
  'nocache_hash' => '1715259555576efc9658d545-58406161',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('__usuario')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<tr id="1">
		<td align="center" class="id"><?php echo $_smarty_tpl->getVariable('item')->value['idUsuario'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->getVariable('item')->value['nombre'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->getVariable('item')->value['username'];?>
</td>
		<td align="center"><?php echo $_smarty_tpl->getVariable('item')->value['tipo'];?>
</td>
		<td align="center"><?php if ($_smarty_tpl->getVariable('item')->value['tipo']=="admin"||$_smarty_tpl->getVariable('item')->value['tipo']=="comisionista"){?> N/A<?php }else{ ?> <?php echo (int)$_smarty_tpl->getVariable('item')->value['totalFolios'];?>
<?php }?></td>
		<td align="center"><?php if ($_smarty_tpl->getVariable('item')->value['tipo']=="admin"||$_smarty_tpl->getVariable('item')->value['tipo']=="comisionista"){?> N/A<?php }else{ ?> <?php echo (int)$_smarty_tpl->getVariable('item')->value['restantes'];?>
<?php }?></td>
		<td class="act">
			<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_dele.png" title="Eliminar" class="spanDelete" id="<?php echo $_smarty_tpl->getVariable('item')->value['idUsuario'];?>
" style="cursor:pointer"/>
			</span> <img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_edit.png" title="Editar" class="spanEdit" style="cursor:pointer" id="<?php echo $_smarty_tpl->getVariable('item')->value['idUsuario'];?>
"/>
			<?php if ($_smarty_tpl->getVariable('item')->value['tipo']!="admin"&&$_smarty_tpl->getVariable('item')->value['tipo']!="comisionista"){?> <img title="Adquisicion de Folios"  class="spanAdqui" id="<?php echo $_smarty_tpl->getVariable('item')->value['idUsuario'];?>
"  src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/desc.png" style="cursor:pointer" /> <?php }?>
		</td>
	</tr>
<?php }} ?>
