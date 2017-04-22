<tr id="conceptoDiv{$key}">
    <td id="conceptoBaseUserId{$key}">{$key}</td>
    <td>{$impuesto.tasa|number_format:2:".":","}%</td>
    <td style="font-family:'Courier New', Courier, monospace; text-align:justify">{$impuesto.impuesto}</td>
    <td>{$impuesto.tipo}</td>
    <td >{if $impuesto.importe <= 0}
        Calculado
    {else}
        {$impuesto.importe|number_format:2:".":","}
    {/if}
	</td>
  	<td><span class="linkBorrarImpuesto" style="cursor:pointer">Borrar</span></td>
</tr>