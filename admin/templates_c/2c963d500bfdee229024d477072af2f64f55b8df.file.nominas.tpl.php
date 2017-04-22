<?php /* Smarty version Smarty3-b7, created on 2016-02-20 12:30:59
         compiled from "templates/nominas.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201514468856c8cd038dda54-86184811%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c963d500bfdee229024d477072af2f64f55b8df' => 
    array (
      0 => 'templates/nominas.tpl',
      1 => 1455433665,
    ),
  ),
  'nocache_hash' => '201514468856c8cd038dda54-86184811',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="center">
	<span id="addVentas" style="cursor:pointer"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" border="0" />Renovar Modulo Nominas</span>
</div>
<div id="content">
	<?php $_template = new Smarty_Internal_Template("lists/nominas.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
