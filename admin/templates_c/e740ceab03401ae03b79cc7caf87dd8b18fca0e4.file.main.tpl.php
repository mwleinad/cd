<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "./templates/menus/main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:155074830256c8a8802c5987-75787787%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e740ceab03401ae03b79cc7caf87dd8b18fca0e4' => 
    array (
      0 => './templates/menus/main.tpl',
      1 => 1455433665,
    ),
  ),
  'nocache_hash' => '155074830256c8a8802c5987-75787787',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>


	<ul id="nav" class="level0">               
      <li><a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
">Inicio</a>      
      </li>
    </ul>
		<ul id="nav" class="level0">               
      <li><a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/reporte-new">Reporte de Ingresos</a>
      </li>
    </ul>

		<ul id="nav" class="level0">               
      <li><a href="http://facturase.com/erpt">Pendientes por Cobrar</a>
      </li>
    </ul>
	
	
    <?php if ($_smarty_tpl->getVariable('info')->value['tipo']=="admin"){?>
		<ul id="nav" class="level0">               
      <li>Administrador              
        <ul class="level1">
          <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/usuario">Usuarios</a>
          </li>
		    <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/paqFolios">Paquete de Folios</a>
          </li>
        </ul>
      </li>
    </ul>
	<?php }?>
	
	<?php if ($_smarty_tpl->getVariable('info')->value['tipo']){?>
	
	<ul class="level0">
      <li>Ordenes              
        <ul class="level1">
          <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/ordenes">Clientes</a>      
          </li>
		     <?php if ($_smarty_tpl->getVariable('info')->value['tipo']=="admin"||$_smarty_tpl->getVariable('info')->value['tipo']=="partner"||$_smarty_tpl->getVariable('info')->value['tipo']=="partnerPro"){?>  
          <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/ventas">Venta de Folios</a> 
          </li>          
		  <?php }?>
      <?php if ($_smarty_tpl->getVariable('info')->value['tipo']=="admin"){?>
          <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/nominas">Renovar o Activar Modulo Nominas</a> 
          </li>
          <li>
            <a href="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/impuestos">Renovar o Activar Modulo Impuestos</a> 
          </li>
      <?php }?>
        </ul>
      </li>
 	</ul>	
	
	<?php }?>




 
