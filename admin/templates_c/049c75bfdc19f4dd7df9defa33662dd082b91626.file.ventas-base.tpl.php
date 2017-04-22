<?php /* Smarty version Smarty3-b7, created on 2017-03-11 09:22:17
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/ventas-base.tpl" */ ?>
<?php /*%%SmartyHeaderCode:83553707058c432493f4242-24022191%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '049c75bfdc19f4dd7df9defa33662dd082b91626' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/ventas-base.tpl',
      1 => 1489252926,
    ),
  ),
  'nocache_hash' => '83553707058c432493f4242-24022191',
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
		<td align="center" <?php if ($_smarty_tpl->getVariable('item')->value['mostrar']=="No"){?> bgcolor="#FFFF00" <?php }?>><?php echo $_smarty_tpl->getVariable('item')->value['cantidad'];?>
</td>
		<td align="center"><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('item')->value['fecha'],"Y-m-d");?>
</td>
		
		<td align="center"><?php if ($_smarty_tpl->getVariable('item')->value['status']=="pagado"){?>Activo <?php }elseif($_smarty_tpl->getVariable('item')->value['status']=="noPagado"){?>No Activo<?php }else{ ?> Cancelado<?php }?>
    <?php if ($_smarty_tpl->getVariable('item')->value['status']=="pagado"){?>
    	(<?php echo $_smarty_tpl->getVariable('item')->value['fechaPagado'];?>
)
    <?php }?>
    </td>
		<td><?php echo urldecode($_smarty_tpl->getVariable('item')->value['rfc']['municipio']);?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['razonSocial'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['factura'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['rfc'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['razonSocial'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['interno'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['metodoPago'];?>
</td>
		<td>$<?php echo $_smarty_tpl->getVariable('item')->value['monto'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['Banco'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('item')->value['autorizacion'];?>
</td>
		<td class="act">
    <?php if ($_smarty_tpl->getVariable('info')->value['idUsuario']==1&&$_smarty_tpl->getVariable('item')->value['mostrar']=="Si"){?>
			<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_dele.png" class="spanDelete" title="Eliminar" id="<?php echo $_smarty_tpl->getVariable('item')->value['idVenta'];?>
"/>
    <?php }?>
      
    	<?php if ($_smarty_tpl->getVariable('item')->value['status']=="noPagado"){?>
      <img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_edit.png" class="spanEdit" title="Editar" id="<?php echo $_smarty_tpl->getVariable('item')->value['idVenta'];?>
"/>
      <?php }?>
      
      <?php if ($_smarty_tpl->getVariable('item')->value['comprobante']){?>
      <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/archivos/<?php echo $_smarty_tpl->getVariable('item')->value['comprobante'];?>
" title="Descargar comprobante">
       	<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/icons/calendar.gif" />
      </a>
      <?php }?>
		</td>
	</tr>
<?php }} ?>
