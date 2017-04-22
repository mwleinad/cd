<?php /* Smarty version Smarty3-b7, created on 2016-06-25 14:50:14
         compiled from "templates/usuario.tpl" */ ?>
<?php /*%%SmartyHeaderCode:387541828576efc963fbcc6-12038169%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa34810efdc0b0aedcf7053ad714188a349cc97b' => 
    array (
      0 => 'templates/usuario.tpl',
      1 => 1455433668,
    ),
  ),
  'nocache_hash' => '387541828576efc963fbcc6-12038169',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="center">
	<span id="addUsuario" style="cursor:pointer"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" border="0" />Agregar Usuario</span>
</div>
<div id="content">
	<?php $_template = new Smarty_Internal_Template("lists/usuario.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
