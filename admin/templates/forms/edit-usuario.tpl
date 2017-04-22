<div id="divForm">
	<form id="editUsuarioForm" name="editUsuarioForm" method="post">
		<fieldset>
		    <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Nombre (s):</div><input name="nombre" id="nombre" type="text" value="{$post.nombre}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Username:</div><input name="username" id="username" type="text" value="{$post.username}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Password:</div><input name="password" id="password" type="text" value="{$post.password}" size="50"/>
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
					<option value="admin" {if $post.tipo=="admin"} selected=selected{/if}>Administrador</option>
					<option value="comisionista" {if $post.tipo=="comisionista"} selected=selected{/if}>comisionista</option>
					<option value="partner"{if $post.tipo=="partner"} selected=selected{/if}>Partner</option>
					</select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editUsuario" name="editUsuario" class="buttonForm" value="Editar Usuario" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditUsuario"/>
			<input type="hidden" id="idUsuario" name="idUsuario" value="{$post.idUsuario}"/>
		</fieldset>
	</form>
</div>
