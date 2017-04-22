{include file="menus/admin.tpl"}
{*include file="menus/periodos.tpl"*}

<div id="divListaPeriodos">
<span style="font-weight:bold">Periodo Actual:</span> {$reporte.periodoId}<br />
<span style="font-weight:bold">Ganancias Periodo:</span> {$reporte.gananciasTotales}<br />
<span style="font-weight:bold">Productos Comprados:</span> {$reporte.productosComprados}<br />
<span style="font-weight:bold">Gastos de Producto:</span> {$reporte.totalPagadoEnProductos}<br />
<span style="font-weight:bold">Total Despu&eacute;s de pagar Producto:</span> {$reporte.totalDespuesDePagarProductos}<br />
<span style="font-weight:bold">Clientes Registrados:</span> {$reporte.clientesRegistrados}<br />
<span style="font-weight:bold">Clientes en Periodo:</span> {$reporte.clientesEnPeriodo}<br />
<span style="font-weight:bold">Clientes Registrados:</span> {$reporte.clientesRegistrados}<br />
<span style="font-weight:bold">Clientes en Linea Activa:</span> {$reporte.clientesEnLineaActiva}<br />
<span style="font-weight:bold">Comisiones directas Entregadas:</span> {$reporte.comisionesDirectasEntregadas}<br />
<span style="font-weight:bold">Total Despu&eacute;s de pagar Comisiones Directas</span> {$reporte.totalDespuesDePagarComisionesDirectas}<br />
<span style="font-weight:bold">Comisiones A Repartir:</span> {$reporte.aRepartir}<br />
<span style="font-weight:bold">Numero de Comisiones Entregadas Totales:</span> {$reporte.numeroDeComisionesEntregadasTotales}<br />
<span style="font-weight:bold">Comisiones A Repartir:</span> {$reporte.aRepartir}<br />
<span style="font-weight:bold">Precio Por Comisi&oacute;n:</span> {$reporte.precioPorComision}<br />
<span style="font-weight:bold">Total Pagos Comisiones:</span> {$reporte.totalPagosComisiones}<br />
<span style="font-weight:bold">Total Ganancias del Periodo:</span> {$reporte.total}<br />
<p></p>
<p>Clientes a los que se les pagara comisiones (Linea Directa)</p>

{foreach from=$reporte.usuariosEnLineaActiva key=key item=user}
{if $user.enLineaActiva == "si"}
  <div>
    <div style="font-weight:bold;float:left;width:150px">{$key}: {$user.userId} : {$user.username} </div>
    <div style="font-weight:bold;float:left;width:150px">Activaci&oacute;n de: {$user.pago.cantidad}</div>
    <div style="font-weight:bold;float:left;width:100px">Comisi&oacute;n: {$user.comision} </div>
    <div style="font-weight:bold;float:left;width:100px">Comisi&oacute;n: {$user.comisionesDirectas} </div>
    <div style="font-weight:bold;float:left;width:100px">Total: {$user.totalComision} </div>
  </div>
  <div style="clear:both"></div>
{/if} 
{/foreach}

<p>Clientes a los que se les pagara comisiones directas</p>

{foreach from=$reporte.usuariosEnLineaActiva key=key item=user}
{if $user.enLineaActiva == "no"}
<div>
	<div style="font-weight:bold;float:left;width:150px">{$key}: {$user.userId} : {$user.username} </div>
	<div style="font-weight:bold;float:left;width:150px">Activacion de: {$user.pago.cantidad}</div>
  <div style="font-weight:bold;float:left;width:100px">Comision: {$user.comision} </div>
  <div style="font-weight:bold;float:left;width:100px">Comision: {$user.comisionesDirectas} </div>
  <div style="font-weight:bold;float:left;width:100px">Total: {$user.totalComision} </div>
</div>
<div style="clear:both"></div>
{/if}
{/foreach}

<p>Clientes que han pagado pero no se les pagara nada (Consumidores)</p>

{foreach from=$reporte.usuariosConsumidores key=key item=user}
<div>
	<div style="font-weight:bold;float:left;width:100px">{$key}: {$user.userId} : {$user.username} </div>
	<div style="font-weight:bold;float:left;width:200px">Activaci&oacute;n de: {$user.pago.cantidad}</div>
  <div style="font-weight:bold;float:left;width:100px">Comisi&oacute;n: {$user.comision} </div>
  <div style="font-weight:bold;float:left;width:100px">Comisi&oacute;n: {$user.comisionesDirectas} </div>
  <div style="font-weight:bold;float:left;width:100px">Total: {$user.totalComision} </div>
</div>
<div style="clear:both"></div>
{/foreach}

</div>
