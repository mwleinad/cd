{foreach from=$paquetes item=item}
	<tr id="1">
    	
		
		<td align="center" class="id" style="font-size:20px">
         	{$item.paqFoliosId}
         </td>
         <td align="center" class="id" style="font-size:20px">
         	{$item.nombre}
         </td>

	       <td align="center" class="id" style="font-size:20px">
         	{$item.cantidad}
         </td>
		 
		 <td align="center" class="id" style="font-size:20px">
         	{$item.monto}
         </td>
	
     
          <td align="center">
          <span><img src="{$WEB_ROOT}/images/b_edit.png" onclick="editPaqFolios({$item.paqFoliosId})" style="cursor:pointer"  title="Editar Paquete de Folios"/></span>
          </td>
	</tr>
{/foreach}