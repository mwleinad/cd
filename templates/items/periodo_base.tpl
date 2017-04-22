<div id="friendsBaseDiv{$friend.user_id}">
	<div id="friendsBaseUserId{$friend.user_id}" style="float:left; width:60px">
	  {$periodo.periodoId}
  </div>
	<div style="float:left;width:180px">
	  De: {$periodo.fromDate}
  </div>
	<div style="float:left;width:150px">
	  A: <span>{$periodo.toDate}</span>
  </div>
	<div style="float:left;width:250px">
	  <span>Status: {$periodo.status}   
    {if $periodo.status == "activo"} |
     <span class="linkFinalizar" style="cursor:pointer">Finalizar</span>
    {/if} 
    {if $periodo.status == "finalizado"}
    	{if $periodo.reporteGenerado == "si"} | 
    	<span class="linkReporte" style="cursor:pointer">Ver Reporte</span>
      {else} |
    	<span class="linkReporte" style="cursor:pointer">Generar Reporte</span>
      {/if}
    {/if}
		</span>
  </div>
  <div style="clear:both"></div>
</div>
<hr />
