{if $totalDesglosado}
<div style="width:750px;">
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Subtotal
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$totalDesglosado.subtotal}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Descuento
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$totalDesglosado.descuento}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	IVA
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$totalDesglosado.iva}
  </div>
  <div style="clear:both"></div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Despues de IVA
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$totalDesglosado.afterIva}
  </div>
	<div style="float:left; width:350px ;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	Total
  </div>
	<div style="float:left; width:250px;border:solid; border-width:1px; border-color:#000; background-color:#FFC; padding:5px">
  	$ {$totalDesglosado.total}
  </div>
  <div style="clear:both"></div>
</div>
{else}
Necesitas Agregar al menos un concepto
{/if}
