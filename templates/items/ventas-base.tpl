{foreach from=$resVentas.items item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idVenta}</td>
		<td align="center">{$item.cantidad}</td>
		<td align="center">{$item.fecha}</td>
		<td align="center">{$item.idSocio}</td>
		<td align="center">{$item.status}</td>
		<td align="center">{$item.idEmpresa}</td>
		<td class="act">
			<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar" id="{$item.idVenta}"/></span>
            <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar" id="{$item.idVenta}"/></a>
		</td>
	</tr>
{/foreach}
