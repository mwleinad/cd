<?php /* Smarty version Smarty3-b7, created on 2016-02-22 07:31:01
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/links/link.tpl" */ ?>
<?php /*%%SmartyHeaderCode:174436464156cb29b57dafe0-93604131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5643064bc6d169c947527d94392a47f229d9044' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/links/link.tpl',
      1 => 1455433658,
    ),
  ),
  'nocache_hash' => '174436464156cb29b57dafe0-93604131',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<a href="<?php echo $_smarty_tpl->getVariable('link')->value;?>
"<?php if ($_smarty_tpl->getVariable('target')->value){?> target="<?php echo $_smarty_tpl->getVariable('target')->value;?>
"<?php }?>><span style="color:#000;"><?php echo $_smarty_tpl->getVariable('name')->value;?>
</span></a>