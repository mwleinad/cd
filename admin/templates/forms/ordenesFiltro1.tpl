<div id="divForm">
	<form id="filtro" name="filtro" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:10%;float:left">B&uacute;squeda:</div>
       Mes <select name="mes" id="mes">
        <option value="todos">Todos</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
        
        
      </select>
	  Status 	<select id="vencimiento" name="vencimiento">
		<option value="todos">Todos</option>
		<option value="vencido">Vencidos</option>
		<option value="novencido">No Vencidos</option>
		<option value="porvencer">Por Vencer</option>
		</select>
	{if $roleId==1}
		Versi&oacute;n <select id="version" name="version">
		<option value="todos">Todos</option>
		<option value="v3">Empresarial</option>
		<option value="auto">CBB</option>
		<option value="construc">Coorporativo</option>
		</select>
	{/if}
	{if $roleId==1} Socio 	<select id="socioId" name="socioId">
		<option value="0">Todos</option>
		{foreach from=$socios item=item}
			<option value="{$item.idUsuario}"> {$item.nombre}</option>
		{/foreach}
		
	</select>
  {/if}

	{if $roleId==1} 
  	<br />Sin Facturar Mas de 2 Meses <input type="checkbox" name="sinFacturar" id="sinFacturar" value="1" />
  {/if}
		
	{if $roleId==1} 
  	Timbres por Terminar <input type="checkbox" name="limite" id="limite" value="1" />
  {/if}

	{if $roleId==1} 
  	Con Timbres sin Activar <input type="checkbox" name="conTimbres" id="conTimbres" value="1" />
  {/if}

	{if $roleId==1} 
  	Activados sin Timbres <input type="checkbox" name="sinTimbres" id="sinTimbres" value="1" />
  {/if}

	{if $roleId==1} 
  	Inactivos <input type="checkbox" name="inactivos" id="inactivos" value="1" />
  {/if}
    
        <input type="button" id="botonFiltro" name="botonFiltro" class="buttonForm1" value="Buscar" />

			</div>
			<div style="clear:both"></div>
			<input type="hidden" id="type" name="type" value="filtro_busqueda"/><br/>
			<div id="loading" style="display:none"><img src="{$WEB_ROOT}/images/loading.gif"> Cargando...</div>
		</fieldset>
	</form>
<br /><br />  
{*}Empresa<input type="search" placeholder="Buscar por nombre"  name="findByName" id="findByName"/>  {*}
</div>


