
<tr id="incapacidadDiv{$key}">
  <td id="incapacidadBaseUserId{$key}">{$key}</td>
  <td>{$incapacidad.tipoIncapacidad}</td>
  <td>{$incapacidad.nombreIncapacidad}</td>
  <td>{$incapacidad.diasIncapacidad}</td>
  <td>{$incapacidad.descuento|number_format:2:".":","}</td>
  <td>{$incapacidad.total|number_format:2:".":","}</td>
  <td> <span class="" style="cursor:pointer" onclick="BorrarIncapacidad({$key})">Borrar</span>
</tr>
