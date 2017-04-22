<?php /* Smarty version Smarty3-b7, created on 2016-02-22 07:31:01
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/status_open_on_popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:87824561856cb29b51a9ef9-88130635%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c76acc9b276976cb6b5d0795de5108c6b9c3c763' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/status_open_on_popup.tpl',
      1 => 1455433624,
    ),
  ),
  'nocache_hash' => '87824561856cb29b51a9ef9-88130635',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
    <div id="centeredDivOnPopup" class="" style="margin:auto; position:fixed; top:50%; left:50%; margin-top:-150px;margin-left:-275px;z-index:3000; display:none">
			<div style="width:548px;  border:solid; border-color:#999;border-width:1px; background-color:#ccc; padding-left:5px; padding-top:5px; padding-bottom:5px">
	<div style="width:500px;  border:solid; border-color:#999;border-width:1px; background-color:#FFF; padding:20px">
       	<div id="close_icon" style="position:absolute;top: 10px; left: 500px;"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/close_icon.gif" onclick="ToogleStatusDivOnPopup()" style="cursor:pointer"/></div>
 