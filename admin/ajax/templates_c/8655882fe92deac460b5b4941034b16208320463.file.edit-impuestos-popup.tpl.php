<?php /* Smarty version Smarty3-b7, created on 2016-03-03 14:26:45
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/edit-impuestos-popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:135344637356d8ba2553db03-85537022%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8655882fe92deac460b5b4941034b16208320463' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/edit-impuestos-popup.tpl',
      1 => 1455433619,
    ),
  ),
  'nocache_hash' => '135344637356d8ba2553db03-85537022',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">Close<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_disn.png" border="0" alt="close" /></span>
		</div>
	</div>
	<div id="ftitl">
		<div class="flabel">Activar Impuestos</div>
		<div id="vtitl"><span title="Titulo">Activar Impuestos</span></div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
		<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/draganddrop.png" border="0" alt="mueve" />
	</div>
</div>
<div class="wrapper">
	<?php $_template = new Smarty_Internal_Template("{$_smarty_tpl->getVariable('DOC_ROOT')->value}/templates/forms/edit-impuestos.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
