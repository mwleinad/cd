<div align="center">
	<span id="addReporte" style="cursor:pointer">Nota: El historial de ingresos por modulo de nomina o impuestos se empezaron a capturar el 24 de Noviembre del 2015 por lo que no se ven reflejados</span>
</div>
<div id="content">
  <table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
    	<tr>
	      <td>A&ntilde;o</td>
	      <td>Mes</td>
	      <td># Ventas Folios Braun</td>
	      <td>Total Folios Vendidos Braun</td>
	      <td>Ingreso por Venta de Folios Braun</td>
	      <td># Ventas Folios Braun Interno</td>
	      <td>Total Folios Vendidos Braun Interno</td>
	      <td>Ingreso por Venta de Folios Braun Interno</td>
	      <td># Ventas Folios</td>
	      <td>Total Folios Vendidos</td>
	      <td>Ingreso por Venta de Folios</td>
	      <td>Nominas Renovadas</td>
	      <td>Ingresos por modulos de nomina</td>
	      <td>Impuestos Renovados</td>
	      <td>Ingreso por Impuestos</td>
	      <td>Ingreso Total</td>
      </tr>

  {foreach from=$resReporte.years key=key item=year}
  	{foreach from=$year key=keyMonth item=month}
    	<tr>
	      <td>{$key}</td>
	      <td>{$month.mes}</td>
	      <td>{$month.noVentasBraun}</td>
	      <td>{$month.foliosBraun}</td>
	      <td>${$month.ingresoPorFoliosBraun|number_format:2}</td>
	      <td>{$month.noVentasBraunInterno}</td>
	      <td>{$month.foliosBraunInterno}</td>
	      <td>${$month.ingresoPorFoliosBraunInterno|number_format:2}</td>
	      <td>{$month.noVentas}</td>
	      <td>{$month.folios}</td>
	      <td>${$month.ingresoPorFolios|number_format:2}</td>
	      <td>{$month.noNominas}</td>
	      <td>${$month.ingresoPorNomina|number_format:2}</td>
	      <td>{$month.noImpuestos}</td>
	      <td>${$month.ingresoPorImpuestos|number_format:2}</td>
	      <td>${$month.ingresoTotal|number_format:2}</td>
      </tr>
    {/foreach}
  {/foreach}
  </table>
  Promedio ingresos mensuales: {$resReporte.promedio}
</div>
