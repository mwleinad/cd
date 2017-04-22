<p>{include file="boxes/white_open.tpl"}

<div id="testmodal" style="display:none; text-align:center">
	{if $user.empresaId == 1214}
	<a href="" title="Simple form"  style="font-size:18px; text-align:center; color:#F00">Tuvimos un problema con la validacion de tu pago. Favor de enviar comprobante de pago a comprobantefiscal@braunhuerin.com.mx para validarlo. Una disculpa por los inconvenientes. Gracias</a> <br /><br />
  {/if}
	<a href="{$WEB_ROOT}/reportePago" title="Simple form"  style="font-size:18px; text-align:center; color:#F00">Tu cuenta ha expirado. Da click aqui para saber las opciones para renovar tu cuenta.</a> <br /><br />
  <a href="{$WEB_ROOT}/sistema/consultar-facturas" style="font-size:18px; text-align:center">
		Da click aqui para ver un reporte de tus comprobantes  
  </a>
</div>


<a href="{$WEB_ROOT}/reportePago">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:4px; border-top-width:4px; border-bottom-width:4px; background-color:#ce352d; border-color:#01355d; padding:5px; width:200px; min-height:200px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:50px">¿Sin Timbres? <br />Clic Aqui</div>
</a>
<a href="{$WEB_ROOT}/reportePago">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#1ba0e1; border-color:#01355d; padding:5px; width:200px; min-height:200px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:50px">¿Sistema Expir&oacute;? <br />Clic Aqui</div>
</a>
<div style="text-align:center; font-size:18px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#fa6900; border-color:#01355d; padding:5px; width:450px; min-height:200px; float:left">
	<p style="font-size:12px; color:#FFF;">Los motivos por los que estas viendo esta pantalla podrian ser:<br />
	  &raquo; Tu cuenta aun no esta ACTIVA<br />
	  &raquo; Has superado el limite de TIMBRES para tu paquete<br />
	  &raquo; Tu cuenta EXPIRO hace poco. Recuerda, los timbres tienen una vigencia de 1 a&ntilde;o, despues de los cuales se congelan y tienes que adquirir un nuevo paquete.<br />
	  &raquo; Tuvimos un problema con tu PAGO y necesitamos corroborar tu deposito<br />
	  <br />
	  Para mas informacion o contactar al area de Soporte.
	  <br />
	  Este recordatorio continuara mostr&aacute;ndose hasta que se validemos su pago. Muchas gracias por su comprension.
  </p>
</div>

</p>
<p>{include file="boxes/white_close.tpl"}
  
</p>
