<?php /* Smarty version Smarty3-b7, created on 2016-03-01 17:36:59
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/nominas-base.tpl" */ ?>
<?php /*%%SmartyHeaderCode:111385905456d643bb63cc72-31355767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fb0f894110dd61beee0799160ee8949b7a4e7cd2' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/nominas-base.tpl',
      1 => 1456001112,
    ),
  ),
  'nocache_hash' => '111385905456d643bb63cc72-31355767',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/libs/plugins/modifier.date_format.php';
?><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resVentas')->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	<tr id="1">
		<td align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('item')->value['fecha'],"Y-m-d");?>
</td>
		
		<td align="center"><?php if ($_smarty_tpl->getVariable('item')->value['status']=="pagado"){?>Activo <?php }elseif($_smarty_tpl->getVariable('item')->value['status']=="noPagado"){?>No Activo<?php }else{ ?> Cancelado<?php }?>
    <?php if ($_smarty_tpl->getVariable('item')->value['status']=="pagado"){?>
    	(<?php echo $_smarty_tpl->getVariable('item')->value['fechaPagado'];?>
)
    <?php }?>
    </td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['razonSocial'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['factura'];?>
</td>
		<td class="act">
			
    	<?php if ($_smarty_tpl->getVariable('item')->value['status']=="noPagado"){?>
      <img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_edit.png" class="spanEdit" title="Editar" id="<?php echo $_smarty_tpl->getVariable('item')->value['idVenta'];?>
"/>
      <?php }?>
		</td>
	</tr>
<?php }} ?>
