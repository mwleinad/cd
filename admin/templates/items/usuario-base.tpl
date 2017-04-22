{foreach from=$__usuario item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idUsuario}</td>
		<td align="center">{$item.nombre}</td>
		<td align="center">{$item.username}</td>
		<td align="center">{$item.tipo}</td>
		<td align="center">{if $item.tipo=="admin" || $item.tipo=="comisionista"} N/A{else} {(int)$item.totalFolios}{/if}</td>
		<td align="center">{if $item.tipo=="admin" || $item.tipo=="comisionista"} N/A{else} {(int)$item.restantes}{/if}</td>
		<td class="act">
			<img src="{$WEB_ROOT}/images/b_dele.png" title="Eliminar" class="spanDelete" id="{$item.idUsuario}" style="cursor:pointer"/>
			</span> <img src="{$WEB_ROOT}/images/b_edit.png" title="Editar" class="spanEdit" style="cursor:pointer" id="{$item.idUsuario}"/>
			{if $item.tipo!="admin" && $item.tipo!="comisionista"} <img title="Adquisicion de Folios"  class="spanAdqui" id="{$item.idUsuario}"  src="{$WEB_ROOT}/images/desc.png" style="cursor:pointer" /> {/if}
		</td>
	</tr>
{/foreach}
