{foreach from=$orden item=mes key=key}
  {if $mes|count>0}
   <thead>
     <tr>
      <th {if $roleId==1}colspan="7" {else} colspan="7" {/if} align="center" style="text-align:center">{$key}</th>
     </tr>
    <tr>
      <th width="70" style="text-align:center">Id</th>
      <th width="70" style="text-align:center">Razon Social</th>
      <th width="150"  style="text-align:center">Vencimiento</th>
      <th width="100" style="text-align:center">M&oacute;dulos Activados</th>
      <th width="100" style="text-align:center">Acciones</th>
    </tr>
  </thead>

		  {foreach from=$mes item=item}	
					{if $item.empresaId != 697}
					<tr id="1">
						<td align="center" class="id"  
							{if $item.statusServicio == "Expirado"} style="background-color:#FF3366" {/if}
						  	{if $item.statusServicio == "PorExpirar"} style="background-color:#FF6" {/if}>
                	{$item.empresaId}
            </td>
           	<td>{$item.rfc.razonSocial}</td>
							{*include file="{$DOC_ROOT}/templates/boxes/datos-basicos.tpl"*}
						<td align="center">
            Vencimiento: {$item.vencimiento}<br />
            Impuestos: {$item.venImpuestos}<br />
            Nomina: {$item.venNomina}<br />
            Registrado el: {$item.activadoEl}
            Interno: {$item.interno}
            </td>
						<td align="center" style="font-size:9px">
            	{if $item.moduloNomina == "Si"}Nom{/if} 
            	{if $item.moduloImpuestos == "Si"}Imp{/if}
            </td>
						
            <td align="center">
                 {if $roleId==1}
                        <span><img src="{$WEB_ROOT}/images/bulleton.png" style="cursor:pointer;" onclick="changeSocio({$item.empresaId})" title="Cambiar Socio"/></span>
                        <span><img src="{$WEB_ROOT}/images/desc.png" style="cursor:pointer;" onclick="changePrice({$item.empresaId})" title="Ver Datos"/></span>
      
      {if $item.activo == 1}
                        <span><img src="{$WEB_ROOT}/images/addn.png" style="cursor:pointer;" onclick="changeActivo({$item.empresaId})" title="Desactivar"/></span>
      {else}
                        <span><img src="{$WEB_ROOT}/images/addn.png" style="cursor:pointer;" onclick="changeActivo({$item.empresaId})" title="Activar"/></span>
      {/if}
                        <span><img src="{$WEB_ROOT}/images/b_dele.png" style="cursor:pointer;" onclick="BorrarEmpresa({$item.empresaId})" title="Borrar"/></span>
                        <br />
                        <a href="javascript:void(0)" onclick="ToggleInterno({$item.empresaId})" title="Convertir a interno o externo">
                        <img src="{$WEB_ROOT}/images/icons/calendar.gif" />
                        </a>
                                        
                {/if}
             
              </td>
						  
					</tr>
          {/if}
	  {/foreach}
  
  {/if}	

{/foreach}