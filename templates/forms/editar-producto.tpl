<!-- Form -->
     
     <div class="m">
		<form name="frmEditarProducto" id="frmEditarProducto" method="post" action="">
		<fieldset>
			<div class="a">
            	<div class="l">No. de Identificaci&oacute;n</div>
                <div class="r"><input type="text" name="noIdentificacion" id="noIdentificacion"  value="{$info.noIdentificacion}" class="largeInput wide2">
              </div>
            </div>
			<div class="a">
            	<div class="l">Descripci&oacute;n *</div>
                <div class="r"><input type="text" name="descripcion" id="descripcion"  value="{$info.descripcion}" class="largeInput wide2">
              </div>
            </div>
            <div class="a">
            	<div class="l">Unidad</div>
                <div class="r"><input type="text" name="unidad" id="unidad"  value="{$info.unidad}"  class="largeInput wide2">
              </div>
            </div>
			<div class="a">
            	<div class="l">Valor Unitario *</div>
                <div class="r"><input type="text" name="valorUnitario" id="valorUnitario"  value="{$info.valorUnitario}"  class="largeInput wide2">
              </div>
            </div>	
			<div class="a">
            	<div class="l">Precio de Compra *</div>
                <div class="r"><input type="text" name="precioCompra" id="precioCompra"  value="{$info.precioCompra}"  class="largeInput wide2">
              </div>
            </div>	

             <div class="a">
            	<div class="l">* Campos requeridos</div>               
            </div>
            <div style="clear:both"></div>
            <div class="a" style="margin-left:270px">
            	<div class="l">&nbsp;</div>
                <div class="r">
                <a class="button" id="btnEditarProducto"><span>Actualizar</span></a></div>
            </div>
            
            <div class="a">
            	<div id="txtMsg"></div>
            </div>	
			<div class="a"></div>
		</fieldset>
        <input type="hidden" name="id_producto" value="{$info.productoId}" />
		</form>
	</div>
     
<!-- End Form -->