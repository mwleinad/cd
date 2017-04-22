    
        
    <div class="clear"></div>
    <div id="portlets">
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div align="center" style="padding-bottom:10px"><b>Filtros de B&uacute;squeda</b></div>
		<div class="portlet-content nopadding">
        <form name="frmBusqueda" id="frmBusqueda" method="post" action="{$WEB_ROOT}/exportar/reporte-nominas.php">
     		<input type="hidden" name="type" id="type" value="buscar" />
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>
                <th width="76" scope="col">RFC</th>
                <th width="102" scope="col">Nombre</th>
                <th width="129" scope="col">Mes</th>
                <th width="79" scope="col">A&ntilde;o</th>
                <th width="123" scope="col">Estatus</th>
                <input type="hidden" size="5" name="comprobante" id="comprobante" class="largeInput" value="0" />
                <th width="120" scope="col">Sucursal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" size="5" name="rfc" id="rfc" class="largeInput" /></td>
                <td><input type="text" size="7" name="nombre" id="nombre" class="largeInput" /></td>
                <td><select name="mes" id="mes"  class="largeInput" style="position:relative;top:-12px" >
                    <option value="0">Todos</option>
                    {foreach from=$meses item=item key=key}
                        <option value="{$item.id}">{$item.nombre}</option>
                    {/foreach}
                </select></td>
                <td><input type="text" size="3" name="anio" id="anio"  class="largeInput"  /></td>
                <td><select name="status_activo" id="status_activo"  class="largeInput" style="position:relative;top:-12px" >
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Cancelados</option>
                </select></td>
                <td width="90"><select name="sucursal" id="sucursal"  class="largeInput" style="position:relative;top:-12px" >
                    <option value="0">Todos</option>
                    {foreach from=$sucursales item=item key=key}
                        <option value="{$item.sucursalId}">{$item.identificador}</option>
                    {/foreach}
                </select></td>
              </tr>
            </tbody>
          </table>
        </form>
		</div>
      </div>

        <div class="folioRowOff" style="width:910px"></div>
        <div align="center">
        	<div style="margin-left:400px">
        	<a class="button" name="btnBuscar" id="btnBuscar"><span>Buscar</span></a>
            </div>
            <div style="clear:both"></div>
            <br />
            {if in_array("create",$nuevosPermisos.consultar_facturas)}
            <div align="right">
            	<a href="javascript:void(0)" onclick="ExportExcel()">
            		<img title="Generar Reporte de Comprobantes" src="{$WEB_ROOT}/images/excel.PNG" width="40" height="40" />
            		<br />            	
            		Exportar Reporte
            	</a>            
            </div>
            <div id="loadBusqueda" style="display:none">
            	<img src="http://www.facturase.com/images/loading.gif" width="16" height="16" />
                <br />Cargando...
            </div>            
            {/if}
        </div>
    </form>
	<!-- End Form -->