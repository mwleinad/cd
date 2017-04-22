{foreach from=$orden item=mes key=key}
  {if $mes|count>0}
		  {foreach from=$mes item=item}	
					
					<tr id="1">
						<td align="center" class="id"  
							{if $item.statusServicio == "Expirado"} style="background-color:#FF3366" {/if}
						  	{if $item.statusServicio == "PorExpirar"} style="background-color:#FF6" {/if}>
                	{$item.empresaId}
            </td>
						<td align="left" class="id" style="font-size:9px">
							{$item.rfc.razonSocial}
            </td>
						<td align="center">
            {$item.vencimiento}
            </td>
						<td align="center">
            {$item.activadoEl}
            </td>
						<td align="center" style="font-size:9px">
            	{if $item.moduloNomina == "Si"}Nom{/if} 
            	{if $item.moduloImpuestos == "Si"}Imp{/if}
            </td>
					</tr>
	  {/foreach}
  
  {/if}	

{/foreach}