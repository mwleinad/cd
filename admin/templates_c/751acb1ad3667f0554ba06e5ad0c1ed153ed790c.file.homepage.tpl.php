<?php /* Smarty version Smarty3-b7, created on 2016-02-20 12:27:31
         compiled from "templates/homepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67529644556c8cc33886625-85216659%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '751acb1ad3667f0554ba06e5ad0c1ed153ed790c' => 
    array (
      0 => 'templates/homepage.tpl',
      1 => 1455433644,
    ),
  ),
  'nocache_hash' => '67529644556c8cc33886625-85216659',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="productsblank">
   <p>Facturase</p>

<?php if (!$_smarty_tpl->getVariable('info')->value['username']){?>

<div id="divForm">
	<form id="loginForm" name="loginForm">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Usuario:</div><input onkeypress="checkTecla(event)" name="username" id="username" type="text" value="<?php echo $_smarty_tpl->getVariable('post')->value['rfc'];?>
" size="50"/>
      </div>
       <div class="formLine">
          <div style="width:30%;float:left">Clave:</div> <input onkeypress="checkTecla(event)" name="password" id="password" type="password" value="<?php echo $_smarty_tpl->getVariable('post')->value['identifier'];?>
" size="50"/><br />
			</div>
      <div style="clear:both"></div>
			<hr />
     	<div class="formLine" style="text-align:center">
      	<input type="button" id="login_0" name="login_0"  class="buttonForm" value="Login" />
     	</div>
  	</fieldset>
	</form>
</div>
<?php }?>

<?php if ($_smarty_tpl->getVariable('info')->value['tipo']=="user"){?>
<div id="divForm">
	<form id="addUsuarioForm" name="addUsuarioForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Username:</div><input disabled="disabled" name="username" id="username" type="text" value="<?php echo $_smarty_tpl->getVariable('info')->value['username'];?>
" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Password:</div><input disabled="disabled" name="password" id="password" type="text" value="Tu Fecha de Nacimiento" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
			</div>
			<div class="formLine" style="width:100%; text-align:left">
			</div>
			<div class="formLine" style="width:100%; text-align:left">
			</div>
		</fieldset>
	</form>
</div>
<?php }?>

</div>
