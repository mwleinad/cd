
<div id="divListaPeriodos">
<span style="font-weight:bold">Periodo Actual:</span> {$reporte.periodoId}<br />
<span style="font-weight:bold">Nombre:</span> {$reporte.info.username}<br />
<span style="font-weight:bold">E-Mail:</span> {$reporte.info.email}<br />
<span style="font-weight:bold">Ya Pagaste para este periodo?:</span> {$reporte.pago.flagPago}<br />
{if $reporte.pago.flagPago == "si"}<span style="font-weight:bold">Activación de:</span> {$reporte.pago.cantidad}<br />{/if}

{if $reporte.pago.flagPago == "no"}<span style="font-weight:bold"><br />Debido a que no se ha registrado tu pago del periodo todos los demás datos son informativos. No recibirás ningún tipo de pago.</span><br /><br />{/if}

<span style="font-weight:bold">Estas en linea activa? (Para pagarte o pagar debes de estar en linea activa)</span> {$reporte.info.enLineaActiva}<br />
<span style="font-weight:bold">Máximo numero de niveles a pagarte:</span> {$reporte.miLineaActiva.0.nivelesAPagar}<br />

<span style="font-weight:bold">Comisiones Ganadas (Esto representa el numero de comisiones verdaderamente ganadas debido al numero de personas en tu linea activa:</span> {$reporte.miLineaActiva.0.numeroDeComisiones}<br />

<span style="font-weight:bold">Comisiones Directas: (Esto se paga solo con que tu pagues tu producto)</span> ${$reporte.miLineaActiva.0.comisionesDirectas}<br />

<p>Mi Descendencia</p>

{foreach from=$listSons key=key item=user}
<div>
  	<div style="font-weight:bold;float:left;width:400px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo; {$key}: {$user.userId} : {$user.username}</div>
  	<div style="font-weight:bold;float:left;width:300px">Pagado: {$user.pago.flagPago}</div>
  
</div>
<div style="clear:both"></div>
{/foreach}

<p>Mi Linea Activa Directa</p>

{foreach from=$reporte.miLineaActiva key=key item=user}
<div>
	{if $reporte.info.userId == $user.userId}
		<div style="font-weight:bold;float:left;width:400px; color:#900">{$key}: {$user.userId} : {$user.username}</div>
	{else}
  	<div style="font-weight:bold;float:left;width:300px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&raquo; {$key}: {$user.userId} : {$user.username}</div>
  {/if} 
  
</div>
<div style="clear:both"></div>
{/foreach}

</div>
