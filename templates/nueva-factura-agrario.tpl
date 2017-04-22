{include file="boxes/white_open.tpl"}

  	<ul>
{if $info.version != "auto" && $certNuevo == ""}
    	<li>No has subido tu Certificado de Sello Digital. Para subirlo Ir a la Secci&oacute;n de Folios > Actualizar Certificado. No podr&aacute;s hacer facturas hasta subirlo.</li>
  {/if}
	{if $noFolios == 0}
    	<li style="color:#C00; font-size:14px">Tienes que subir al menos una serie de Folios. Para hacerlo ve a Folios > Nuevos Folios. No podr&aacute;s hacer facturas hasta hacerlo.</li>
  {/if}
	{if $info.version == "auto" && $qrs == 0}
    	<li style="color:#C00; font-size:14px">No has subido tu C&oacute;digo de Barras Bidimensional. Para subirlo ve a la secci&oacute;n de Folios > Cambiar QR</li>
  {/if}
	{if $countClientes == 0}
    	<li style="color:#C00; font-size:14px">Tienes que agregar al menos un cliente. Para crearlo ve a la secci&oacute;n de Clientes > Nuevo Cliente</li>
  {/if}  
  
    </ul>
	{include file="forms/nueva-factura-agrario.tpl"}


	{include file="boxes/footer_factura.tpl"}

{include file="boxes/white_close.tpl"}

