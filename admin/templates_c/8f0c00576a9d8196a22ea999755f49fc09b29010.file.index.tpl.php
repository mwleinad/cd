<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:176872431456c8a8801ee5b3-14512526%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f0c00576a9d8196a22ea999755f49fc09b29010' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/index.tpl',
      1 => 1455433645,
    ),
  ),
  'nocache_hash' => '176872431456c8a8801ee5b3-14512526',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facturase</title>
<meta name="description" content=""  />
<meta name="keywords" content=""  />

<link href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/css/style.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/js-config.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/prototype.js"></script>
<script src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/scoluos/src/scriptaculous.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/util.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/functions.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/datetimepicker.js" type="text/javascript"></script>

<script src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/javascript/<?php echo $_smarty_tpl->getVariable('page')->value;?>
.js" type="text/javascript"></script>

</head>
<body>

<div style="position:relative" id="divStatus"></div>
<div class="wrapper">
	<?php $_template = new Smarty_Internal_Template("header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

	<?php $_template = new Smarty_Internal_Template("main.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

	<?php $_template = new Smarty_Internal_Template("bottom.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
<?php $_template = new Smarty_Internal_Template("footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</body>
</html>