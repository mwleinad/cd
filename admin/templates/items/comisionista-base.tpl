{foreach from=$comisionista item=item}
	<tr id="1">
    	<td aling="center"><span><img src="{$WEB_ROOT}/images/addn.png" class="showreferido" id="{$item.empresaId}" title="Ver referidos"/></span></td>
		<td align="center" class="id" {if $item.statusServicio == "Expirado"} style="background-color:#FF3366" 			{/if}{if $item.statusServicio == "PorExpirar"} style="background-color:#FF6" {/if}>{$item.empresaId}</td>
		<td align="center" class="id" style="font-size:9px">
         	{$item.rfc.razonSocial} - {$item.rfc.rfc}
         </td>
         <td align="center" class="id" style="font-size:9px">
         	{$item.rfc.rfc}
         </td>

	
	
		<td align="center">{$item.telefono}</td>
		<td align="center">{$item.socio.razonSocial}</td>

		<td align="center" style="font-size:9px">{$item.email}</td>
		<td align="center" style="font-size:9px">{$item.password}</td>

		<td align="center">
       		{$item.tipoSocio}
          </td>
          <td aling="center">
          {$item.porcentaje}
          </td>
          <td aling="center">
          {$item.Pagado}
          </td>
           <td aling="center">
          {$item.Adeudo}
          </td>
          <td aling="center">
          <span><img src="{$WEB_ROOT}/images/b_edit.png" class="Editpor" id="{$item.empresaId}" title="Editar Porcentaje"/></span>
          </td>
	</tr>
{/foreach}
