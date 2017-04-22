{foreach from=$resVentas.items item=item key=key}
	<tr id="1">
		<td align="center" {if $item.mostrar == "No"} bgcolor="#FFFF00" {/if}>{$item.cantidad}</td>
		<td align="center">{$item.fecha|date_format:"Y-m-d"}</td>
		{*}<td align="center">{$item.idSocio}</td>{*}
		<td align="center">{if $item.status=="pagado"}Activo {elseif $item.status=="noPagado"}No Activo{else} Cancelado{/if}
    {if $item.status == "pagado"}
    	({$item.fechaPagado})
    {/if}
    </td>
		<td>{$item.rfc.municipio|urldecode}</td>
		<td>{$item.rfc.razonSocial}</td>
		<td>{$item.factura}</td>
		<td>{$item.rfc.rfc}</td>
		<td>{$item.razonSocial}</td>
		<td>{$item.interno}</td>
		<td>{$item.metodoPago}</td>
		<td>${$item.monto}</td>
		<td>{$item.Banco}</td>
		<td>{$item.autorizacion}</td>
		<td class="act">
    {if $info.idUsuario == 1 && $item.mostrar == "Si"}
			<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar" id="{$item.idVenta}"/>
    {/if}
      
    	{if $item.status == "noPagado"}
      <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar" id="{$item.idVenta}"/>
      {/if}
      
      {if $item.comprobante}
      <a href="{$WEB_ROOT}/archivos/{$item.comprobante}" title="Descargar comprobante">
       	<img src="{$WEB_ROOT}/images/icons/calendar.gif" />
      </a>
      {/if}
		</td>
	</tr>
{/foreach}
