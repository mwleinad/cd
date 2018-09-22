  <tr>
    <td align="center">
        {if in_array("create",$nuevosPermisos.reporte_ventas)}
        {if $fact.facturado == 0}
            <input type="checkbox" name="checkTicket[]" value="{$fact.notaVentaId}" />
        {/if}
        {/if}
    </td>
    <td width="34" align="center">{$fact.notaVentaId}</td>
    <td width="34" align="center">{$fact.serie} {$fact.folio}</td>
    <td width="34" align="center">{$fact.rfc}</td>
    <td width="34" align="center">{$fact.razonSocial}</td>
    <td width="34" align="center">{$fact.identificador|urldecode}</td>
    <td align="center">{$fact.fecha}</td>
    <td align="center">${$fact.total|number_format:2:'.':','}</td>
    <td align="center">
    <!-- Campo a validar   -->
    <span style="color:{if $fact.statusPayment == "Pagada"}#009966{else}#C30{/if}">
        ${$fact.payments}
    </span>
    </td>
    <td width="90" align="center">
    <a href="javascript:void(0)">
                    {if in_array("view",$nuevosPermisos.reporte_ventas)}
                    <img src="{$WEB_ROOT}/images/icons/details.png" class="spanDetails" id="{$fact.notaVentaId}" border="0" title="Ver Detalles" />
                    {/if}
                  {if in_array("delete",$nuevosPermisos.reporte_ventas)}
                  	{if $fact.status == 1 && $fact.fStatus != 1}
                  	<a href="javascript:void(0)"><img src="{$WEB_ROOT}/images/icons/cancel.png" class="spanCancel" id="{$fact.notaVentaId}" border="0" title="Cancelar"/></a>
                  	{/if}
                  {/if}
    {if in_array("delete",$nuevosPermisos.reporte_ventas)}
      {if $fact.status == 1}
      <!--botón agregar pago-->
      				{*if $fact.statusPayment != "Pagada"*}
                    <img src="{$WEB_ROOT}/images/payment.png" class="spanPayments" id="{$fact.notaVentaId}" border="0" title="Agregar Pago" style="cursor:pointer;" />		{/if}
      {*/if*}
    {/if}
    {if in_array("create",$nuevosPermisos.reporte_ventas)}
      {if $fact.facturado == 0}
                    <img src="{$WEB_ROOT}/images/icons/re-facturar.png" width="16px" height="16px" class="spanFacturar" id="{$fact.notaVentaId}" border="0" title="Facturar Ticket" style="cursor:pointer;" />
                    
                    <img src="{$WEB_ROOT}/images/b_edit.png" width="16px" height="16px" class="" onclick="editarConceptos({$fact.notaVentaId})" id="{$fact.notaVentaId}" border="0" title="Editar Conceptros" style="cursor:pointer;" />
                    
      {/if}
    {/if}
            </td>
  </tr>
