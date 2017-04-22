<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:56:20
         compiled from "/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/datos-basicos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:36093365056c8a8c4c7d615-87501140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb7db83082be0eedcf67f04139a00e128abd41a5' => 
    array (
      0 => '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/templates/boxes/datos-basicos.tpl',
      1 => 1455433618,
    ),
  ),
  'nocache_hash' => '36093365056c8a8c4c7d615-87501140',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_replace')) include '/var/www/vhosts/comprobantedigital.mx/httpdocs/sistema/admin/libs/plugins/modifier.replace.php';
?>            	<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Razon Social</td>
              	<td width="70%" width="50%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['razonSocial'];?>
</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">RFC</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['rfc'];?>
</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Direccion</td>
              	<td width="70%" width="50%" style="font-size:12px"><?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['calle'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['noExt'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['noInt'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['colonia'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['localidad'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['municipio'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['estado'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['pais'],"%20"," ");?>
 <?php echo smarty_modifier_replace($_smarty_tpl->getVariable('item')->value['rfc']['cp'],"%20"," ");?>
</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Usuario</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['email'];?>
</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Password</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['password'];?>
</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Ultima Factura</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['ultimaExpedida'];?>
</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Limite/Expedidas</td>
              	<td width="70%" style="font-size:12px" <?php if ($_smarty_tpl->getVariable('item')->value['terminar']==1){?> style="background-color:#C30"<?php }?>><?php echo $_smarty_tpl->getVariable('item')->value['limite'];?>
 / <?php echo $_smarty_tpl->getVariable('item')->value['expedidos'];?>
</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Activo</td>
              	<td width="70%" style="font-size:12px"><?php if ($_smarty_tpl->getVariable('item')->value['activo']==1){?>Si<?php }else{ ?>No<?php }?></td>
              </tr>

              <tr style="font-size:12px">
              	<td width="100%" colspan="2" style="font-size:12px; text-align:center">Datos de Contacto</td>
              </tr>
              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Persona Contacto</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['nombrePer'];?>
</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Telefono Empresarial</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['telefono'];?>
</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Telefono Contacto</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['telefonoPer'];?>
</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Celular Contacto</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['celularPer'];?>
</td>
              </tr>
              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Correo Contacto</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['emailPer'];?>
</td>
              </tr>

              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Localidad</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['rfc']['localidad'];?>
</td>
              </tr>
						<?php if ($_smarty_tpl->getVariable('roleId')->value==1){?>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Socio</td>
              	<td width="70%" style="font-size:12px"><?php echo $_smarty_tpl->getVariable('item')->value['socio']['razonSocial1'];?>
</td>
              </tr>
            <?php }?>
             </table>