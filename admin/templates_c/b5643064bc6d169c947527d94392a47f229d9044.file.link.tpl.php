<?php /* Smarty version Smarty3-b7, created on 2016-02-20 12:34:16
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/links/link.tpl" */ ?>
<?php /*%%SmartyHeaderCode:210007357456c8cdc8983317-28046138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5643064bc6d169c947527d94392a47f229d9044' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/links/link.tpl',
      1 => 1455433658,
    ),
  ),
  'nocache_hash' => '210007357456c8cdc8983317-28046138',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<a href="<?php echo $_smarty_tpl->getVariable('link')->value;?>
"<?php if ($_smarty_tpl->getVariable('target')->value){?> target="<?php echo $_smarty_tpl->getVariable('target')->value;?>
"<?php }?>><span style="color:#000;"><?php echo $_smarty_tpl->getVariable('name')->value;?>
</span></a>