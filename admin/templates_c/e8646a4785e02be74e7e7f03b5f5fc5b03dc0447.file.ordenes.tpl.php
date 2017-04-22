<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "./templates/lists/ordenes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54872835556c8a8804199b1-85097650%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8646a4785e02be74e7e7f03b5f5fc5b03dc0447' => 
    array (
      0 => './templates/lists/ordenes.tpl',
      1 => 1455433661,
    ),
  ),
  'nocache_hash' => '54872835556c8a8804199b1-85097650',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('roleId')->value==2){?>	
	<table>
	<thead>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('info2')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
		<tr>
			<td colspan=5> Total de Folios Adquiridos: <?php echo $_smarty_tpl->getVariable('item')->value['totalFolios'];?>
</td>
			<td colspan=6> Folios Restantes: <?php echo $_smarty_tpl->getVariable('item')->value['restantes'];?>
</td>
		</tr>
	  <?php }} ?>
	  </thead>
   </table>
<?php }?>	

<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
<tbody>
	<?php $_template = new Smarty_Internal_Template("{$_smarty_tpl->getVariable('DOC_ROOT')->value}/templates/items/ordenes-base.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</tbody>
</table>

<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
   <thead>
    <tr>
      <th width="70" style="text-align:center">Mes</th>
      <th width="200"  style="text-align:center">Total</th>
    </tr>
  </thead>
<tbody>
<?php  $_smarty_tpl->tpl_vars['mes'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('orden')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['mes']->key => $_smarty_tpl->tpl_vars['mes']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mes']->key;
?>
     <tr>
      <td align="center" style="text-align:center"><?php echo $_smarty_tpl->getVariable('key')->value;?>
</td>
      <td align="center" style="text-align:center"><?php echo count($_smarty_tpl->getVariable('mes')->value);?>
</td>
     </tr>
<?php }} ?>
</tbody>
</table>
