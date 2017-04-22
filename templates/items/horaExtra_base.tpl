
<tr id="horaExtraDiv{$key}">
  <td id="horaExtraBaseUserId{$key}">{$key}</td>
  <td>{$horaExtra.tipoHoras}</td>
  <td>{$horaExtra.dias}</td>
  <td>{$horaExtra.horasExtra}</td>
  <td>{$horaExtra.importePagado|number_format:2:".":","}</td>
  <td>{$horaExtra.total|number_format:2:".":","}</td>
  <td> <span class="" style="cursor:pointer" onclick="BorrarHoraExtra({$key})">Borrar</span>
</tr>
