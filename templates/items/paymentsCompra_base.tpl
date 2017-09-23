<tr>
    <td><div align="center">{$prod.paymentDate|date_format:"%d-%m-%Y"}</div></td>
    <td><div align="center">${$prod.amount|number_format:2:'.':','}</div></td>
    <td> 
    <div align="center">
    <a href="javascript:void(0)" title="Eliminar">
        {if $prod.comprobantePagoId}
            {*descargar xml*}
            <a target="_blank" href="{$WEB_ROOT}/cfdi33-generate-pdf&filename=UID_{$prod.comprobantePagoId}&type=download">
                <img src="{$WEB_ROOT}/images/pdf_icon.png" height="16" width="16" border="0" title="Descargar PDF"/>
            </a>
            {*descargar xml*}
            <a href="{$WEB_ROOT}/sistema/descargar-xml/item/{$prod.comprobantePagoId}">
                <img src="{$WEB_ROOT}/images/icons/descargar.png" border="0" width="16" />
            </a>
        {/if}
        <img src="{$WEB_ROOT}/images/b_dele.png" onclick="DeletePayment({$prod.paymentId})" class="spanDeletePayment" id="{$prod.paymentId}"/>
    </a>
    </div>
    </td>
</tr>