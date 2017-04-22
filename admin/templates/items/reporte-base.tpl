{foreach from=$resReporte.items item=item key=key}
	<tr id="1">
		<td align="center" class="id">{$item.idReporte}</td>
		<td align="center">{$item.date}</td>
		<td class="act">
    <a href="{$WEB_ROOT}/pdf/reporte.php?id={$item.idReporte}">Ver Reporte</a>
			<img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar"  id="{$item.idReporte}"/></span>
			<img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit"  title="Editar" id="{$item.idReporte}"/></a>
		</td>
	</tr>
{/foreach}
