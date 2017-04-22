<div id="divForm">
	<form id="filtro" name="filtro" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Filtrar por tipo:</div>
        <select name="tipo" id="tipo">
        <option value="propios">Medios Propios</option>
        <option value="pac">PAC</option>
        <option value="auto">Autoimpresi&oacute;n</option>
        </select>
        <input type="button" id="botonFiltro" name="botonFiltro" class="buttonForm" value="Filtrar" />

			</div>
			<div style="clear:both"></div>
			<input type="hidden" id="type" name="type" value="filtrar"/>
		</fieldset>
	</form>
<br /><br />  
<input type="search" placeholder="Buscar por nombre"  name="findByName" id="findByName"/>  
</div>
