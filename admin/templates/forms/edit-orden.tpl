<div id="divForm">
	<form id="editOrdenForm" name="editOrdenForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Status:</div>
       <select  name="status" id="status">
       <option value="pagado">Activa</option>
       <option value="cancelado">No Activa</option>
       </select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editOrden" name="editOrden" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditOrden"/>
			<input type="hidden" id="idOrden" name="idOrden" value="{$post.idOrden}"/>
		</fieldset>
	</form>
</div>
