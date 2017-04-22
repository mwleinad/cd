<?php /* Smarty version Smarty3-b7, created on 2016-03-01 17:37:06
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/add-nominas-popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12887155656d643c234afa7-14046487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0938f2d11ee648c64a4eac82e12a67fa0d0003c' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/add-nominas-popup.tpl',
      1 => 1455433615,
    ),
  ),
  'nocache_hash' => '12887155656d643c234afa7-14046487',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">Cerrar<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_disn.png" border="0" alt="close" /></span>
		</div>
	</div>
	<div id="ftitl">
		<div class="flabel">Renovar Modulo Nominas</div>
		<div id="vtitl"><span title="Titulo">Folios</span></div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
		<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/draganddrop.png" border="0" alt="mueve" />
	</div>
</div>
<div class="wrapper">
	<?php $_template = new Smarty_Internal_Template("{$_smarty_tpl->getVariable('DOC_ROOT')->value}/templates/forms/add-nominas.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
