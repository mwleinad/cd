<div id="divForm">
    <form id="conceptoForm" name="conceptoForm" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" id="action" name="action" value="agregarXML"  />
        
        <span id="loadingDivConcepto"></span>
        <div class="formLine">
            <div style="width:500px;float:left">Archivo con formato XML:(*)</div> 
            <div style="clear:both"></div>
        </div>  
        
        <div class="formLine">
            <div style="width:500px;float:left">
            	<input width="400px" name="xml" id="xml" type="file" value=""  size="170" class="largeInput" placeholder="XML del proveedor"/>
            </div>
        	</div>
        
        	<div style="width:132px;float:left;"><a class="button" id="agregarCertificado" name="agregarCertificado" onclick="AgregarCertificado()"><span>Subir XML</span></a> </div>
        	<div style="clear:both"></div>
        </div>  
        <div class="formLine">
        	<div style="clear:both"></div>
        	<hr />   
        </div> 
    </form>
{if $data}    
<div style="width:750px;">
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	UUID
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	{$data.UUID}
  </div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	RFC
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	{$data.nodoEmisor.rfc.rfc}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Razon Social
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	{$data.nodoEmisor.rfc.razonSocial}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Serie y Folio
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	{$data.serie.serie} {$data.folio}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Tipo de Comprobante
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	{$data.tipoDeComprobante}
  </div>
  <div style="clear:both"></div>
</div>        
{/if}
    Conceptos Cargados:
    <div id="conceptos">
    	{if !$data}
    	Ninguno (Has click en Subir para poder agregar conceptos)
      {else}
      	    <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
		<div class="portlet-content nopadding">
        <form action="" method="post">
        <input type="hidden" id="action" name="action" value="Confirmar" />
        <input type="hidden" id="uuid" name="uuid" value="{$data.UUID}" />
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>
                <th width="70" scope="col">Agregar a Inventario</th>
                <th width="150" scope="col">Cantidad</th>
                <th width="150" scope="col">Unidad</th>
                <th width="150" scope="col">Id</th>
                <th width="109" scope="col">Descripcion</th>
                <th width="89" scope="col">Precio de Compra</th>
                <th width="89" scope="col">Precio de Venta</th>
                <th width="81" scope="col">Importe</th>
              </tr>
            </thead>
            <tbody>
            {foreach from=$data.conceptos key=key item=item}
	              <tr>
                <td ><input type="checkbox" name="concepto[]" id="concepto[]" checked="checked" value="{$item.noIdentificacion}"/></td>
                <td >{$item.cantidad}</td>
                <td>{$item.unidad}</td>
                <td>{$item.noIdentificacion}</td>
                <td>{$item.descripcion}</td>
                <td>{$item.valorUnitario}</td>
                <td><input type="text" name="precioVenta[{$item.noIdentificacion}]" id="precioVenta[{$item.noIdentificacion}]" class="smallInput" size="10"  value="{$item.valorUnitario}"/></td>
                <td>{$item.importe}</td>
      					</td>
              </tr>
              {/foreach}
              </tbody>
              <tr>
              <td colspan="6" style="text-align:center">
              <input type="submit" value="Confirmar Compra" /></td>
              </tr>
              </table>
              
              </form>
             </div></div></div>
             <div>Desmarca sino quieres que el producto se agregue a tu inventario</div>
      {/if}
    </div>
    <br />
    <div style="clear:both"></div>
    
    <div class="formLine">
        <div>Totales Desglosados</div> 
        <div id="totalesDesglosadosDiv">
        {if $data}
	        
<div style="width:750px;">

	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Subtotal
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$data.totales.subtotal}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Descuento
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$data.totales.descuento}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	IVA
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$data.totales.iva}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Total
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$data.totales.total}
  </div>
  <div style="clear:both"></div>
</div>          
          
        {else}
        
        {/if}  
        </div>
        <hr />
    </div>
      <div style="clear:both"></div>
    
    <div class="formLine" style="text-align:center" id ="reemplazarBoton">
    	{*}<a class="button" id="generarFactura" name="generarFactura"><span>Finalizar Venta</span></a>{*}
    </div>
</div>