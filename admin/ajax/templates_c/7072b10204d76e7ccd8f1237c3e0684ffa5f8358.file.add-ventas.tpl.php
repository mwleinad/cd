<?php /* Smarty version Smarty3-b7, created on 2016-02-22 07:30:48
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/add-ventas.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186690145156cb29a8515874-00675917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7072b10204d76e7ccd8f1237c3e0684ffa5f8358' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/forms/add-ventas.tpl',
      1 => 1455433634,
    ),
  ),
  'nocache_hash' => '186690145156cb29a8515874-00675917',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="divForm">
Paquete Minimo es de 50 Facturas.
	<form id="addVentasForm" name="addVentasForm" method="post">
		<fieldset>
	 
	 <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('datos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
	    <div class="formLine" style="width:100%; text-align:left">
		      
		<div style="width:30%;float:left">Folios Disponibles: </div><?php echo $_smarty_tpl->getVariable('item')->value['restantes'];?>

		<?php $_smarty_tpl->assign("disponibles","{$_smarty_tpl->getVariable('item')->value['restantes']}",null,null);?> 
		 </div>
	  <?php }} ?>
			<div class="formLine" style="width:100%; text-align:left">

				<div style="width:30%;float:left">Cantidad:</div>
				
				
				 <select id="cantidad" name="cantidad" style="width:300px">
				   <option  value="1">1 facturas</option>

				   <option  value="50">50 facturas</option>
				   <option  value="100">100 facturas</option>
				   <option  value="150">150 facturas</option>
				   <option  value="300">300 facturas</option>
				   <option  value="500">500 facturas</option>
				   <option  value="1000">1000 facturas</option>
				   <option  value="1500">1500 facturas</option>
				 </select>
			</div>
		
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Empresa:</div>
        <select  name="idEmpresa" id="idEmpresa" style="width:300px">
        <?php  $_smarty_tpl->tpl_vars['orden'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resOrden')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['orden']->key => $_smarty_tpl->tpl_vars['orden']->value){
?>
        	<option value="<?php echo $_smarty_tpl->getVariable('orden')->value['empresaId'];?>
"><?php echo $_smarty_tpl->getVariable('orden')->value['razonSocial'];?>
</option>
         <?php }} else { ?> 
		 <option >No hay empresas asignadas a usted</option>
		  <?php } ?> 
       	</select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<?php if (count($_smarty_tpl->getVariable('resOrden')->value)>0){?><input type="button" id="addVentas" name="addVentas" class="buttonForm" value="Agregar" /><?php }?>
			</div>
			<input type="hidden" id="type" name="type" value="saveAddVentas"/>
			<input type="hidden" id="disponibles" name="disponibles" value="<?php echo $_smarty_tpl->getVariable('disponibles')->value;?>
"/>
			<input type="hidden" id="idVenta" name="idVenta" value="<?php echo $_smarty_tpl->getVariable('post')->value['idVenta'];?>
"/>
		</fieldset>
	</form>
</div>
