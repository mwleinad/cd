<?php /* Smarty version Smarty3-b7, created on 2016-02-20 12:27:55
         compiled from "templates/impuestos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:130078212156c8cc4b2b1df5-90597131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e736b0bffd427ab04b2bd2350503714e6130b29c' => 
    array (
      0 => 'templates/impuestos.tpl',
      1 => 1455433644,
    ),
  ),
  'nocache_hash' => '130078212156c8cc4b2b1df5-90597131',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="center">
	<span id="addVentas" style="cursor:pointer"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" border="0" />Renovar Modulo Impuestos</span>
</div>
<div id="content">
	<?php $_template = new Smarty_Internal_Template("lists/impuestos.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
