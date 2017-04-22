<?php /* Smarty version Smarty3-b7, created on 2016-02-22 07:31:17
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/edit-ventas-popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161066497156cb29c567a9b1-39214324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '427e5064fe12edcbaa481922866cf8c62e566ced' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/edit-ventas-popup.tpl',
      1 => 1455433622,
    ),
  ),
  'nocache_hash' => '161066497156cb29c567a9b1-39214324',
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
		<div class="flabel">Editar Ventas</div>
		<div id="vtitl"><span title="Titulo">Editar Ventas</span></div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
		<img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/draganddrop.png" border="0" alt="mueve" />
	</div>
</div>
<div class="wrapper">
	<?php $_template = new Smarty_Internal_Template("{$_smarty_tpl->getVariable('DOC_ROOT')->value}/templates/forms/edit-ventas.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</div>
