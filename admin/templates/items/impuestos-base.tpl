{foreach from=$resVentas.items item=item key=key}
	<tr id="1">
		<td align="center">{$item.fecha|date_format:"Y-m-d"}</td>
		{*}<td align="center">{$item.idSocio}</td>{*}
		<td align="center">{if $item.status=="pagado"}Activo {elseif $item.status=="noPagado"}No Activo{else} Cancelado{/if}
    {if $item.status == "pagado"}
    	({$item.fechaPagado})
    {/if}
    </td>
    
		<td>{$item.rfc.razonSocial}</td>
		<td>{$item.factura}</td>
		<td class="act">
			{*}<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar" id="{$item.idVenta}"/>
      {*}
    	{if $item.status == "noPagado"}
      <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar" id="{$item.idVenta}"/>
      {/if}
		</td>
	</tr>
{/foreach}
