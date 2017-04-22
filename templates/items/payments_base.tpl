<tr>
    <td><div align="center">{$prod.paymentDate|date_format:"%d-%m-%Y"}</div></td>
    <td><div align="center">${$prod.amount|number_format:2:'.':','}</div></td>
    <td> 
    <div align="center">
    <a href="javascript:void(0)" title="Eliminar">
        <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDeletePayment" id="{$prod.paymentId}"/>
    </a>
    </div>
    </td>
</tr>