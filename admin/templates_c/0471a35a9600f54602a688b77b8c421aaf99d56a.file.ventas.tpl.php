<?php /* Smarty version Smarty3-b7, created on 2016-02-20 12:34:16
         compiled from "templates/ventas.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152558219956c8cdc87f4464-20658940%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0471a35a9600f54602a688b77b8c421aaf99d56a' => 
    array (
      0 => 'templates/ventas.tpl',
      1 => 1455433669,
    ),
  ),
  'nocache_hash' => '152558219956c8cdc87f4464-20658940',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="center">
	<span id="addVentas" style="cursor:pointer"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" border="0" />Agregar Folios</span>
</div>
<div id="content">
	<?php $_template = new Smarty_Internal_Template("lists/ventas.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
