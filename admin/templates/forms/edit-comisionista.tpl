<div id="divForm">
	<form id="editComisionistaForm" name="editComisionistaForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Porcentaje:</div><input name="porcentaje" id="porcentaje" type="text" value="{$Myusuario.porcentaje}" size="50"/>
                
                <div style="width:30%;float:left">Adeudo:</div><input name="adeudo" id="adeudo" type="text" value="{$Myusuario.Pagado}" size="50"/>
                
                <div style="width:30%;float:left">Pagado:</div><input name="pagado" id="pagado" type="text" value="{$Myusuario.Adeudo}" size="50"/>
			</div>
            <div class="formLine" style="text-align:center">
				<input type="button" id="editComisionista" name="editComisionista" class="buttonForm" value="Editar Comisionista" />
			
			<input type="hidden" id="type" name="type" value="saveEditComisionista"/>
			<input type="hidden" id="idEmpresa" name="idEmpresa" value="{$Myusuario.empresaId}"/>
		</fieldset>
	</form>
</div>
