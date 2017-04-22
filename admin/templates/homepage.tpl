<div id="productsblank">
   <p>Facturase</p>

{if !$info.username}

<div id="divForm">
	<form id="loginForm" name="loginForm">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Usuario:</div><input onkeypress="checkTecla(event)" name="username" id="username" type="text" value="{$post.rfc}" size="50"/>
      </div>
       <div class="formLine">
          <div style="width:30%;float:left">Clave:</div> <input onkeypress="checkTecla(event)" name="password" id="password" type="password" value="{$post.identifier}" size="50"/><br />
			</div>
      <div style="clear:both"></div>
			<hr />
     	<div class="formLine" style="text-align:center">
      	<input type="button" id="login_0" name="login_0"  class="buttonForm" value="Login" />
     	</div>
  	</fieldset>
	</form>
</div>
{/if}

{if $info.tipo == "user"}
<div id="divForm">
	<form id="addUsuarioForm" name="addUsuarioForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Username:</div><input disabled="disabled" name="username" id="username" type="text" value="{$info.username}" size="50"/>
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
{/if}

</div>
