<div id="divForm">
    <form id="nuevaFactura" name="nuevaFactura" method="post">
    	<input type="hidden" id="tasaIva" name="tasaIva" value="{$iva}" />
        <input type="hidden" id="algo" name="algo" value="no" />
        <div class="formLine">
            <div style="width:90px;float:left">Sucursal:</div>
            <div style="width:255px;float:left">
            <select name="sucursalId" id="sucursalId"  class="largeInput" style="width:185px">
            {foreach from=$sucursales item=sucursal}
            <option value="{$sucursal.sucursalId}">{$sucursal.identificador|utf8_decode}</option>
            {/foreach}
            </select></div>
            <div style="width:150px;float:left">% Descuento General:</div>
            <div style="width:155px;float:left">
            	<input name="porcentajeDescuento" id="porcentajeDescuento" type="text" value=""  size="10" maxlength="3" class="largeInput" placeholder="% Descuento"/>
            </div>
            <div style="clear:both"></div>
          </div>          
		</form>
        
    <form id="conceptoForm" name="conceptoForm">
        <input type="hidden" id="type" name="type" value="agregarConcepto" />
        
        <span id="loadingDivConcepto"></span>
        <div class="formLine">
            <div style="width:85px;float:left">Cantidad</div> 
            <div style="width:100px;float:left"># Identificacion</div> 
            <div style="width:100px;float:left">Unidad</div>
	          <div style="width:100px;float:left">Valor S/IVA</div>
  	        <div style="width:100px;float:left">Valor C/IVA</div>
            <div style="width:85px;float:left">Exento IVA</div>
            <div style="width:150px;float:left">Precio Compra</div>
            <div style="clear:both"></div>
        </div>  
        
        <div class="formLine">
            <div style="width:85px;float:left">
            	<input name="cantidad" id="cantidad" type="text" value=""  size="6" class="largeInput" placeholder="Cantidad"/>
            </div>
            <div style="width:100px;float:left">
                <input name="noIdentificacion" id="noIdentificacion" type="text" value=""  size="8"  class="largeInput" placeholder="# Identificacion"/>
                <div style="position:relative">
                <div style="display:none;position:absolute;top:-2px; left:2px; z-index:100" id="suggestionProductDiv">
                </div>
        		</div>
        	</div>
        
            <div style="width:100px;float:left">
            	<input name="unidad" id="unidad" type="text" value=""  size="8" class="largeInput"  placeholder="Unidad"/>
            </div>
          <div style="width:100px;float:left">
          <input name="valorUnitario" id="valorUnitario" type="text" value=""  size="8" class="largeInput"  placeholder="Valor S/I"  onblur="UpdateValorUnitarioConIva()"/></div>
          <div style="width:100px;float:left">
          <input name="valorUnitarioCI" id="valorUnitarioCI" type="text" value=""  size="8" class="largeInput"  placeholder="Valor C/I" onblur="UpdateValorUnitarioSinIva()"/></div>
        	<div style="width:85px;float:left">
                <select name="excentoIva" id="excentoIva" class="largeInput" style="width:70px">
                {foreach from=$excentoIva item=iva}
                <option value="{$iva}">{$iva}</option> <br />
                {/foreach}
                </select>
			</div>
          <div style="width:150px;float:left">
          <input name="precioCompra" id="precioCompra" disabled="disabled" type="text" value=""  size="8" class="largeInput"  placeholder="Precio Compra"/></div>

        	<div style="width:132px;float:left; cursor:pointer" id="agregarConceptoDiv" class="button"><span>Agregar</span></div>
        	<div style="clear:both"></div>
        </div>  
        <div class="formLine">
        	<div style="width:100%;float:left">
        		<textarea placeholder="Escribe tu concepto aqu&iacute; (*)" name="descripcion" id="descripcion" rows="5" class="largeInput wide" style="width:98%">{$post.descripcion}</textarea>
        	</div>
        	<div style="clear:both"></div>
        	<hr />   
        </div> 
    </form>
    Conceptos Cargados:
    <div id="conceptos">
    	Ninguno (Has click en Agregar para agregar un concepto)
    </div>
    <br />
    <div style="clear:both"></div>
    
    <div class="formLine">
        <div>Totales Desglosados</div> 
        <div id="totalesDesglosadosDiv">
	        Necesitas Agregar al menos un concepto
        </div>
        <hr />
    </div>
      <div style="clear:both"></div>
    
    <div class="formLine" style="text-align:center" id ="reemplazarBoton">
    	<a class="button" id="generarFactura" name="generarFactura"><span>Finalizar Venta</span></a>
    </div>
</div>