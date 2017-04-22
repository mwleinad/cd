
<tr id="deduccionDiv{$key}">
  <td id="deduccionBaseUserId{$key}">{$key}</td>
  <td>{$deduccion.tipoDeduccion}</td>
  <td>{$deduccion.nombreDeduccion}</td>
  <td>{$deduccion.importeGravado|number_format:2:".":","}</td>
  <td>{$deduccion.importeExcento|number_format:2:".":","}</td>
  <td>{$deduccion.total|number_format:2:".":","}</td>
  <td> <span class="" style="cursor:pointer" onclick="BorrarDeduccion({$key})">Borrar</span>
</tr>
