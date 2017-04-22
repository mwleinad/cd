{if $roleId==2}	
	<table>
	<thead>
		{foreach from=$info2 item=item}
		<tr>
			<td colspan=5> Total de Folios Adquiridos: {$item.totalFolios}</td>
			<td colspan=6> Folios Restantes: {$item.restantes}</td>
		</tr>
	  {/foreach}
	  </thead>
   </table>
{/if}	

<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
<tbody>
	{include file="{$DOC_ROOT}/templates/items/ordenes-base.tpl"}
</tbody>
</table>

<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
   <thead>
    <tr>
      <th width="70" style="text-align:center">Mes</th>
      <th width="200"  style="text-align:center">Total</th>
    </tr>
  </thead>
<tbody>
{foreach from=$orden item=mes key=key}
     <tr>
      <td align="center" style="text-align:center">{$key}</td>
      <td align="center" style="text-align:center">{$mes|count}</td>
     </tr>
{/foreach}
</tbody>
</table>
