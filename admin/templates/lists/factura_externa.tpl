<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
   <thead>
    <tr>
      <th width="70" style="text-align:center">Proyecto</th>
      <th width="200"  style="text-align:center">Total de comprobantes emitidos</th>
    </tr>
  </thead>
<tbody>
{foreach from=$proyecto item=item key=key}
     <tr>
      <td align="center" style="text-align:center">{$item.nombre}</td>
      <td align="center" style="text-align:center">{$item.numero_comprobantes}</td>
     </tr>
{/foreach}
</tbody>
</table>
