{foreach from=$__config item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idConfig}</td>
		<td align="center">{$item.email}</td>
		<td align="center">{$item.home}</td>
		<td align="center">{$item.nosotros}</td>
		<td class="act">
			<img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar"id="{$item.idConfig}"/></a>
		</td>
	</tr>
{/foreach}
