<div id="divForm">
	<form id="filtro" name="filtro" method="post">
    <input type="hidden" value="filtro_busqueda" id="type" name="type"/>
		<fieldset>
        
        <table>
        	<tr>
                <td colspan="2" style="text-align:center">
                    Fecha Inicial 
                </td>
                <td colspan="2" style="text-align:center">
                    Fecha Final 
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align:center">Mes</td>
                <td style="text-align:center">A&ntilde;o</td>
                <td style="text-align:center">Mes</td>
                <td style="text-align:center">A&ntilde;o</td>
                <td></td>
            </tr>
            <tr>
           		<td style="text-align:center">
               		<select name="fechaInicial" id="fechaInicial" style="padding:5px">
                    {foreach from=$meses item=item}
                    <option value="{$item.id}">{$item.nombre}</option>         
                    {/foreach}
            		</select>
                </td>
           		<td style="text-align:center">
               		<select name="anioInicial" id="anioInicial" style="padding:5px">
                     {for $foo=2000 to 2020}
                    <option value="{$foo}" {if $anioActual eq $foo} selected="selected"{/if}>{$foo}</option>         
					{/for}
            		</select>
                </td>

          		<td style="text-align:center">
               		<select name="fechaInicial" id="fechaInicial" style="padding:5px">
                    {foreach from=$meses item=item}
                    <option value="{$item.id}">{$item.nombre}</option>         
                    {/foreach}
            		</select>
                </td>
                <td style="text-align:center">
               		<select name="anioFinal" id="anioInicial" style="padding:5px">
                     {for $foo=2000 to 2016}
                    <option value="{$foo}" {if $anioActual eq $foo} selected="selected"{/if}>{$foo}</option>         
					{/for}
            		</select>
                </td>
            	<td style="text-align:center">
                	<input type="button" id="botonFiltro" name="botonFiltro" class="buttonForm" value="Filtrar" onclick="Busqueda()" style="padding:3px"/>
                </td>
            </tr>
        </table>
		</fieldset>
	</form>
    <div style="clear:both"></div>
    <input type="hidden" id="type" name="type" value="filtro_busqueda"/><br/>
    <div id="loading" style="display:none"><img src="{$WEB_ROOT}/images/loading.gif"> Cargando...</div>
</div>
