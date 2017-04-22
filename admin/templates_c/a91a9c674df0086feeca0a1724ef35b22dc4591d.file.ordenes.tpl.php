<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "templates/ordenes.tpl" */ ?>
<?php /*%%SmartyHeaderCode:123974746756c8a880369828-39058936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a91a9c674df0086feeca0a1724ef35b22dc4591d' => 
    array (
      0 => 'templates/ordenes.tpl',
      1 => 1455433666,
    ),
  ),
  'nocache_hash' => '123974746756c8a880369828-39058936',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="ordenesDiv">
    <div align="center">
  		<?php $_template = new Smarty_Internal_Template("forms/ordenesFiltro1.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

    </div>
    
    <div id="content" class="content">
			<?php $_template = new Smarty_Internal_Template("lists/ordenes.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

    </div>
</div>