
<tr id="otroPagoDiv{$key}">
  <td id="otroPagoBaseUserId{$key}">{$key}</td>
  <td>{$otroPago.tipoOtroPago}</td>
  <td>{$otroPago.nombreOtroPago}</td>
  <td>{$otroPago.importe|number_format:2:".":","}</td>
  <td>{$otroPago.total|number_format:2:".":","}</td>
  <td> <span class="" style="cursor:pointer" onclick="BorrarOtroPago({$key})">Borrar</span>
</tr>
