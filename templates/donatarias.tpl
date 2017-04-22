{include file="boxes/white_open.tpl"}
  	<ul>
{if $info.version != "auto" && $certNuevo == ""}
    	<li>No has subido tu Certificado de Sello Digital. Para subirlo Ir a la Sección de Folios > Actualizar Certificado. No podrás hacer facturas hasta subirlo.</li>
  {/if}
	{if $noFolios == 0}
    	<li style="color:#C00; font-size:14px">Tienes que subir al menos una serie de Folios. Para hacerlo ve a Folios > Nuevos Folios. No podrás hacer facturas hasta hacerlo.</li>
  {/if}
	{if $info.version == "auto" && $qrs == 0}
    	<li style="color:#C00; font-size:14px">No has subido tu Código de Barras Bidimensional. Para subirlo ve a la sección de Folios > Cambiar QR</li>
  {/if}
	{if $countClientes == 0}
    	<li style="color:#C00; font-size:14px">Tienes que agregar al menos un cliente. Para crearlo ve a la sección de Clientes > Nuevo Cliente</li>
  {/if}  
  
    </ul>

{include file="forms/donatarias.tpl"}

{include file="boxes/white_close.tpl"}

