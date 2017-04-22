<?php /* Smarty version Smarty3-b7, created on 2017-02-11 12:06:23
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/ordenes-base.tpl" */ ?>
<?php /*%%SmartyHeaderCode:710037084589f6ebf602458-41229616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b437e1e86b857e97c7a7a97392f96f550653485' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/items/ordenes-base.tpl',
      1 => 1486842861,
    ),
  ),
  'nocache_hash' => '710037084589f6ebf602458-41229616',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['mes'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('orden')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['mes']->key => $_smarty_tpl->tpl_vars['mes']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mes']->key;
?>
  <?php if (count($_smarty_tpl->getVariable('mes')->value)>0){?>
   <thead>
     <tr>
      <th <?php if ($_smarty_tpl->getVariable('roleId')->value==1){?>colspan="7" <?php }else{ ?> colspan="7" <?php }?> align="center" style="text-align:center"><?php echo $_smarty_tpl->getVariable('key')->value;?>
</th>
     </tr>
    <tr>
      <th width="70" style="text-align:center">Id</th>
      <th width="70" style="text-align:center">Razon Social</th>
      <th width="150"  style="text-align:center">Vencimiento</th>
      <th width="100" style="text-align:center">M&oacute;dulos Activados</th>
      <th width="100" style="text-align:center">Acciones</th>
    </tr>
  </thead>

		  <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('mes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>	
					<?php if ($_smarty_tpl->getVariable('item')->value['empresaId']!=697){?>
					<tr id="1">
						<td align="center" class="id"  
							<?php if ($_smarty_tpl->getVariable('item')->value['statusServicio']=="Expirado"){?> style="background-color:#FF3366" <?php }?>
						  	<?php if ($_smarty_tpl->getVariable('item')->value['statusServicio']=="PorExpirar"){?> style="background-color:#FF6" <?php }?>>
                	<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>

            </td>
           	<td><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['razonSocial'];?>
</td>
							
						<td align="center">
            Vencimiento: <?php echo $_smarty_tpl->getVariable('item')->value['vencimiento'];?>
<br />
            Impuestos: <?php echo $_smarty_tpl->getVariable('item')->value['venImpuestos'];?>
<br />
            Nomina: <?php echo $_smarty_tpl->getVariable('item')->value['venNomina'];?>
<br />
            Registrado el: <?php echo $_smarty_tpl->getVariable('item')->value['activadoEl'];?>

            Interno: <?php echo $_smarty_tpl->getVariable('item')->value['interno'];?>

            </td>
						<td align="center" style="font-size:9px">
            	<?php if ($_smarty_tpl->getVariable('item')->value['moduloNomina']=="Si"){?>Nom<?php }?> 
            	<?php if ($_smarty_tpl->getVariable('item')->value['moduloImpuestos']=="Si"){?>Imp<?php }?>
            </td>
						
            <td align="center">
                 <?php if ($_smarty_tpl->getVariable('roleId')->value==1){?>
                        <span><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/bulleton.png" style="cursor:pointer;" onclick="changeSocio(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Cambiar Socio"/></span>
                        <span><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/desc.png" style="cursor:pointer;" onclick="changePrice(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Ver Datos"/></span>
      
      <?php if ($_smarty_tpl->getVariable('item')->value['activo']==1){?>
                        <span><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" style="cursor:pointer;" onclick="changeActivo(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Desactivar"/></span>
      <?php }else{ ?>
                        <span><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/addn.png" style="cursor:pointer;" onclick="changeActivo(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Activar"/></span>
      <?php }?>
                        <span><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/b_dele.png" style="cursor:pointer;" onclick="BorrarEmpresa(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Borrar"/></span>
                        <br />
                        <a href="javascript:void(0)" onclick="ToggleInterno(<?php echo $_smarty_tpl->getVariable('item')->value['empresaId'];?>
)" title="Convertir a interno o externo">
                        <img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/icons/calendar.gif" />
                        </a>
                                        
                <?php }?>
             
              </td>
						  
					</tr>
          <?php }?>
	  <?php }} ?>
  
  <?php }?>	

<?php }} ?>