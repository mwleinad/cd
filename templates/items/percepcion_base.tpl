
<tr id="percepcionDiv{$key}">
  <td id="percepcionBaseUserId{$key}">{$key}</td>
  <td>{$percepcion.tipoPercepcion}</td>
  <td>{$percepcion.nombrePercepcion}</td>
  <td>{$percepcion.importeGravado|number_format:2:".":","}</td>
  <td>{$percepcion.importeExcento|number_format:2:".":","}</td>
  <td>{$percepcion.total|number_format:2:".":","}</td>
  <td> <span class="" style="cursor:pointer" onclick="BorrarPercepcion({$key})">Borrar</span>
</tr>
