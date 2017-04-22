<div id="divForm">
	<form id="addConfigForm" name="addConfigForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Email:</div><input name="email" id="email" type="text" value="{$post.email}" size="50"/>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addConfig" name="addConfig" class="buttonForm" value="Agregar Config" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddConfig"/>
			<input type="hidden" id="idConfig" name="idConfig" value="{$post.idConfig}"/>
		</fieldset>
	</form>
</div>
