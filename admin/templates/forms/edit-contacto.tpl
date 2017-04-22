<div id="divForm">
	<form id="editContactoForm" name="editContactoForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Nombre:</div><input disabled="disabled" name="nombre" id="nombre" type="text" value="{$post.nombre}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Email:</div><input disabled="disabled" name="email" id="email" type="text" value="{$post.email}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tel&eacute;fono:</div><input disabled="disabled" name="telefono" id="telefono" type="text" value="{$post.telefono}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Texto:</div><textarea disabled="disabled" name="texto" cols="50" rows="10" id="texto">{$post.texto}</textarea>
			</div>
			<div style="clear:both"></div>
			<hr />
			<input type="hidden" id="type" name="type" value="saveEditContacto"/>
			<input type="hidden" id="idContacto" name="idContacto" value="{$post.idContacto}"/>
		</fieldset>
	</form>
</div>
