<div id="divForm">
	<form id="frmSocioEdit" name="frmSocioEdit" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Socio :</div>
       <select  name="socioId" id="socioId">
          {foreach from=$listUsuarios item=soc}
		  <option value="{$soc.idUsuario}" {if $infoEmpresa.socioId==$soc.idUsuario} selected=selected {/if}> {$soc.nombre} </option>
          {/foreach}
       </select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editSocio" name="editSocio" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="changeSocioSave"/>
			<input type="hidden" id="empresaId" name="empresaId" value="{$empresaId}"/>
		</fieldset>
	</form>
</div>
