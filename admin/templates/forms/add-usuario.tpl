<div id="divForm">
	<form id="addUsuarioForm" name="addUsuarioForm" method="post">
		<fieldset>
		<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Nombre(s):</div><input name="nombre" id="nombre" type="text"  size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Username:</div><input name="username" id="username" type="text" value="{$post.username}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Password:</div><input name="password" id="password" type="password" value="{$post.password}" size="50"/>
			</div>
			
			
			<div class="formLine" style="width:100%; text-align:left">
			</div>
			<div class="formLine" style="width:100%; text-align:left">
			</div>
			<div class="formLine" style="width:100%; text-align:left">
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tipo:</div>
				  {*}<input name="tipo" id="tipo" type="text" value="{$post.tipo}" size="50"/>{*}
				    <select name="tipo" id="tipo" width="200px" style="width:330px">
					<option value="admin">Administrador</option>
					<option value="partner">Partner</option>
					<option value="partnerPro">Partner Pro</option>
					<option value="comisionista">Comisionista</option>
					</select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addUsuario" name="addUsuario" class="buttonForm" value="Agregar Usuario" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddUsuario"/>
			<input type="hidden" id="idUsuario" name="idUsuario" value="{$post.idUsuario}"/>
		</fieldset>
	</form>
</div>
