
<div id="divForm">
	<form id="addContactoForm" name="addContactoForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">*Nombre:</div><input name="nombre" id="nombre" type="text" value="{$post.nombre}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">*Email:</div><input name="email" id="email" type="text" value="{$post.email}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Teléfono:</div><input name="telefono" id="telefono" type="text" value="{$post.telefono}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">*Texto:</div><textarea name="texto" cols="50" rows="10" id="texto">{$post.texto}</textarea>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addContacto" name="addContacto" class="buttonForm" value="Envia tu comentario o pregunta." />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddContacto"/>
			<input type="hidden" id="idContacto" name="idContacto" value="{$post.idContacto}"/>
		</fieldset>
	</form>
</div>