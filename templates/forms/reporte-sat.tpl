<div id="divForm">
	<form id="generarReporte" name="generarReporte" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">Mes:</div>
         <div style="width:15%;float:left">	
         	<select name="mes" id="mes" class="largeInput">
         	{foreach from=$meses item=mes key=key}
          <option value="{$key}" {if $prevMes == $key} selected="selected" {/if}>{$mes}</option> <br />
          {/foreach}
          </select></div>
          <div style="clear:both"></div>
      </div>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">Ano:</div>
         <div style="width:15%;float:left">	
         	<select name="anio" id="anio" class="largeInput">
         	{foreach from=$anios item=anio key=key}
          <option value="{$key}" {if $thisAnio == $key} selected="selected" {/if}>{$anio}</option> <br />
          {/foreach}
          </select></div>
          <div style="clear:both"></div>
      </div>


      <div style="clear:both"></div>
			<hr />
     	<div class="formLine" style="text-align:center">
      	<a class="button" id="generarReporteButton" name="generarReporteButton"><span>Generar Reporte Mensual para el SAT</span></a>
     	</div>
         
  	</fieldset>
	</form>
</div>
