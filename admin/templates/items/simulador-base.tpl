{foreach from=$__simulador item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idSimulador}</td>
		<td align="center">{$item.montoAFinanciar}</td>
		<td align="center">{$item.tasa}</td>
		<td align="center">{$item.ivaTasa}</td>
		<td align="center">{$item.totalTasa}</td>
		<td align="center">{$item.cuotaApertura}</td>
		<td align="center">{$item.ivaCuota}</td>
		<td align="center">{$item.totalCoutaApertura}</td>
		<td align="center">{$item.tipoDeNomina}</td>
		<td align="center">{$item.descuento}</td>
		<td align="center">{$item.pago}</td>
		<td align="center">{$item.sueldoMensual}</td>
		<td class="act">
			<img src="{$WEB_ROOT}/images/b_dele.png" title="Eliminar" class="spanDelete" id="{$item.idSimulador}"/></span> 
			<img src="{$WEB_ROOT}/images/b_edit.png" title="Editar" class="spanEdit" id="{$item.idSimulador}"/></a>
		</td>
	</tr>
{/foreach}
