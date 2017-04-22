 {if $info.moduloImpuestos == "Si"}
  <tr>
    <td width="" align="center">Modulo de Impuestos</td>
    <td width="" align="center">{$info.venImpuestos|date_format:"%d/%m/%Y"}</td>
  </tr>
  {/if}  

  {if $info.moduloNomina == "Si"}
  <tr>
    <td width="" align="center">Modulo de Nomina</td>
    <td width="" align="center">{$info.venNomina|date_format:"%d/%m/%Y"}</td>
  </tr>
  {/if}  