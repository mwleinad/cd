{foreach from=$resOrden.items item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idOrden}</td>
		<td align="center">{$item.fecha|date_format:"d-m-Y"}</td>
		{*}<td align="center">{$item.idSocio}</td>{*}
		<td align="center">{if $item.status=="pagado"} Activo {else} No Activo {/if}
    {if $item.status == "pagado"}
    ({$item.fechaPagado})
    {/if}
    </td>
		<td >{$item.rfc.razonSocial}</td>
		<td class="act">
			{*}<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar" id="{$item.idOrden}"/>
      {*}
      {if $item.status == "noPagado"}
      <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar" id="{$item.idOrden}"/>
      {/if}
		</td>
	</tr>
{/foreach}
