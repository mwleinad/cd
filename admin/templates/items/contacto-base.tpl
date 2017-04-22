{if count($__contacto.items)}
	{foreach from=$__contacto.items item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idContacto}</td>
		<td align="center">{$item.nombre}</td>
		<td align="center">{$item.email}</td>
		<td align="center">{$item.telefono}</td>
		<td align="center" width="600">{$item.texto}</td>
		<td class="act">
			<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar"id="{$item.idContacto}"/></span>
			<img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit"title="Editar"id="{$item.idContacto}"/></a>
		</td>
	</tr>
	{/foreach}
{/if}
