{if ($SITENAME == "PASCACIO" OR $SITENAME == "FACTURASE")}  
<!-- Facebook Popup Widget START --><!-- Brought to you by www.JasperRoberts.com - www.TheBlogWidgets.com -->
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript'></script>
<style>
#fanback {
display:none;
background:rgba(0,0,0,0.8);
width:100%;
height:100%;
position:fixed;
top:0;
left:0;
z-index:99999;
}
#fan-exit {
width:100%;
height:100%;
}
#JasperRoberts {
background:white;
width:420px;
height:310px;
position:absolute;
top:45%;
left:63%;
margin:-220px 0 0 -375px;
-webkit-box-shadow: inset 0 0 50px 0 #939393;
-moz-box-shadow: inset 0 0 50px 0 #939393;
box-shadow: inset 0 0 50px 0 #939393;
-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
margin: -220px 0 0 -375px;
}
#TheBlogWidgets {
float:right;
cursor:pointer;
background:url(http://3.bp.blogspot.com/-NRmqfyLwBHY/T4nwHOrPSzI/AAAAAAAAAdQ/8b9O7O1q3c8/s1600/TheBlogWidgets.png) repeat;
height:15px;
padding:20px;
position:relative;
padding-right:40px;
margin-top:-20px;
margin-right:-22px;
}
.remove-borda {
height:1px;
width:366px;
margin:0 auto;
background:#F3F3F3;
margin-top:16px;
position:relative;
margin-left:20px;
}
#linkit,#linkit a.visited,#linkit a,#linkit a:hover {
color:#80808B;
font-size:10px;
margin: 0 auto 5px auto;
float:center;
}
</style>


<script type='text/javascript'>
//<![CDATA[
jQuery.cookie = function (key, value, options) {

// key and at least value given, set cookie...
if (arguments.length > 1 && String(value) !== "[object Object]") {
options = jQuery.extend({}, options);

if (value === null || value === undefined) {
options.expires = -1;
}

if (typeof options.expires === 'number') {
var days = options.expires, t = options.expires = new Date();
t.setDate(t.getDate() + days);
}

value = String(value);

return (document.cookie = [
encodeURIComponent(key), '=',
options.raw ? value : encodeURIComponent(value),
options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
options.path ? '; path=' + options.path : '',
options.domain ? '; domain=' + options.domain : '',
options.secure ? '; secure' : ''
].join(''));
}

// key and possibly options given, get cookie...
options = value || {};
var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
//]]>
</script>
<script type='text/javascript'>
jQuery(document).ready(function($){
if($.cookie('popup_user_login') != 'yes'){
$('#fanback').delay(2000).fadeIn('medium');
$('#TheBlogWidgets').click(function(){
$('#fanback').stop().fadeOut('medium');
});
}
$.cookie('popup_user_login', 'no', { path: '/', expires: 7 });
});
</script>

<div id='fanback'>
	<div id='fan-exit'>
	</div>
	<div id='JasperRoberts'>
		<div id='TheBlogWidgets'>
		</div>
		<div class='remove-borda'>
		</div>
		<iframe allowtransparency='true' frameborder='0' scrolling='no' src='//www.facebook.com/plugins/likebox.php?

href=https://www.facebook.com/comprobantedigital?ref=ts&width=402&height=70&colorscheme=light&show_faces=false&show_border=false&stream=false&header=false'

style='border: none; overflow: hidden; margin-top: -19px; width: 402px; height: 70px;'></iframe>
		<center>
		<span style="color:#a8a8a8;font-size:8px;" id="linkit">Powered by <a rel="nofollow" style="color:#a8a8a8;font-size:8px;" href="http://trazzos.com">Trazzos</a></span>
	  </center>
		<center>
		<p><b>Regalanos un Like, son gratis y nos ayudas a seguir creciendo!</b><br />
	  </center>

	</div>
</div>
<!-- Facebook Popup Widget END. Brought to you by www.JasperRoberts.com - www.TheBlogWidgets.com -->
{/if}


 {include file="boxes/white_open.tpl"}
  	<ul>
	{if $info.razonSocial == "" && $info.empresaId > 1175}
  <div style="font-size:18px; border:solid; border-width:1px; background-color:#FF9; padding:5px">
    	No has configurado tus datos de RFC <a href="{$WEB_ROOT}/datos-generales">Configuracion > Mi Empresa.</a>
  </div>   
  {/if}

	{if $info.version != "auto" && $certNuevo == ""}
  <div style="font-size:18px; border:solid; border-width:1px; background-color:#FF9; padding:5px">
    	No has subido tu Certificado de Sello Digital. Para subirlo Ir a la Secci&oacute;n de <a href="{$WEB_ROOT}/admin-folios/actualizar-certificado">Configuracion > Actualizar Certificado.</a>
  </div>   
  {/if}
	{if $noFolios == 0}
  <div style="font-size:18px; border:solid; border-width:1px; background-color:#FF9; padding:5px">
    	Tienes que subir al menos una serie de Folios. Para hacerlo ve a <a href="{$WEB_ROOT}/admin-folios/nuevos-folios">Configuracion > Folios > Nuevos Folios.</a>
  </div>    
 {/if}
	{if $countClientes == 0}
	  <div style="font-size:18px; border:solid; border-width:1px; background-color:#FF9; padding:5px">
    	Tienes que agregar al menos un cliente. Para crearlo ve a la secci&oacute;n de <a href="{$WEB_ROOT}/cliente">CFDI's > Clientes > Nuevo Cliente</a></div>
  {/if}
    </ul>
    
    {if $renew == 1}
   	<div style="font-size:14px; border:solid; border-width:1px; background-color:#eee; padding:5px">
       	 
            <p>Recuerda que el {$vencimiento.vencimiento} es la fecha l&iacute;mite para realizar el pago de renovaci&oacute;n de tu sistema, a partir del cual se suspender&aacute; y no podr&aacute; seguir elaborando m&aacute;s Comprobantes.</p>
            <p>Si desea continuar disfrutando de nuestro servicio contactanos al correo <a href="mailto:comprobantefiscal@braunhuerin.com.mx">comprobantefiscal@braunhuerin.com.mx</a></p>
	</div>
  {/if}
    
<div style="text-align:center">
<br />

{if $info.empresaId > 1000}
Tutorial Basico<br />
<iframe width="640" height="360" allowTransparency="true" mozallowfullscreen webkitallowfullscreen allowfullscreen style="background-color:transparent;" frameBorder="0" src="https://app.ilosvideos.com/embed/rXt7zospkz91"></iframe>
{/if}

{if $info.empresaId > 1000}<br />
Adquirir Timbres y Reportar Pago<br />
<iframe width="640" height="360" allowTransparency="true" mozallowfullscreen webkitallowfullscreen allowfullscreen style="background-color:transparent;" frameBorder="0" src="https://app.ilosvideos.com/embed/vQf9JfC1fHK8"></iframe>{/if}

</div>
{if ($SITENAME == "PASCACIO" OR $SITENAME == "FACTURASE")}  
{/if}

{*}    
<div style="font-size:18px; border:solid; border-width:1px; background-color:#FF9; padding:5px">
	Despu&eacute;s  de la generaci&oacute;n del sello digital, puede tardar hasta 5 d&iacute;as para que el SAT los autorice basados en la lista de LCO. Si recibe el error "El RFC  no est&aacute; autorizado a firmar con el certificado XXXXXXXXXXXXXXXXXXXX (seg&uacute;n LCO).", entonces los sellos no han sido autorizados. Por favor, sea paciente mientras el SAT los autoriza.
    <br />En ocasiones si despu&eacute;s de 3 d&iacute;as no se ha recibido la autorizaci&oacute;n es posible que haya sido declinada, en este caso recomendamos hacer un nuevo sello. Si tampoco funciona acuda al centro de atenci&oacute;n del SAT m&aacute;s cercano.
</div>
{*}

{if $info.empresaId < 1000}
<a href="{$WEB_ROOT}/videos">
<div style="text-align:center; font-size:18px; border:solid; border-right-width::2px; border-left-width:4px; border-top-width:4px; border-bottom-width:0px; background-color:#60a917; border-color:#01355d; padding:5px; width:830px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">Bienvenido al nuevo y mejorado Sistema para la Generacion de Comprobantes Digitales.<br />Funciona exactamente igual que el anterior pero hemos movido los menus y agregado algunas funcionalidades. Para saber que tenemos de nuevo, visita nuestra seccion de Videos Tutoriales<br />Clic Aqui</div>
</a>
{/if}
<div style="clear:both"></div>

<a href="{$WEB_ROOT}/reportePago">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:4px; border-top-width:4px; border-bottom-width:4px; background-color:#ce352d; border-color:#01355d; padding:5px; width:200px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">¿Sin Timbres? <br />Clic Aqui</div>
</a>
<a href="{$WEB_ROOT}/reportePago">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#1ba0e1; border-color:#01355d; padding:5px; width:200px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">¿Sistema Proximo a Expirar? <br />Clic Aqui</div>
</a>

<a href="{$WEB_ROOT}/videos">
<div style="text-align:center; font-size:18px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#fa6900; border-color:#01355d; padding:5px; width:400px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">¿Necesitas Ayuda? <br />Clic Aqui</div>
</a>

<div style="clear:both"></div>
<a href="{$WEB_ROOT}/vencimientos">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:4px; border-top-width:4px; border-bottom-width:4px; background-color:#d3cc09; border-color:#01355d; padding:5px; width:200px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">¿Cuando Expira mi Sistema o Modulos? <br />Clic Aqui</div>
</a>
<a href="{$WEB_ROOT}/admin-folios/actualizar-certificado">
<div style="text-align:center; font-size:14px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#db50ad; border-color:#01355d; padding:5px; width:200px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">¿Cuando Expira mi Sello Digital? <br />Clic Aqui</div>
</a>

<div style="text-align:center; font-size:18px; border:solid; border-right-width::2px; border-left-width:2px; border-top-width:4px; border-bottom-width:4px; background-color:#16499a; border-color:#01355d; padding:5px; width:400px; min-height:125px; float:left">
<p style="font-size:18px; color:#FFF; padding-top:20px">
<a href="{$WEB_ROOT}/privacidad" style="color:#FFF">
&raquo; Consulta nuestra Politica de Privacidad<br />
</a>
<a href="{$WEB_ROOT}/terminos" style="color:#FFF">
&raquo; Consulta los Terminos y Condiciones del Servicio.
</a>


<div>{*}
<div style="text-align:center; font-size:18px; border:solid; border-width:1px; background-color:#FFC; padding:5px">

<p style="font-size:18px; color:#900">
Si encuentras alg&uacute;n error favor de presionar las teclas CTRL + R para refrescar la p&aacute;gina, eso elimina la mayor&iacute;a de los errores, esto es ocasionado por los archivos temporales de tu navegador.</p>

Si quieres que tu cliente pueda entrar a ver o generar sus facturas favor de proporcionarle  la siguiente direcci&oacute;n web.<br />
<a href="{$WEB_ROOT}/acceso-cliente">{$WEB_ROOT}/acceso-cliente</a><br />Para configurar la cantidad de d&iacute;as que tu cliente tiene para generar su factura ir a la secci&oacute;n de Configuraci&oacute;n > Mi Empresa > Editar</div>{*}
<p>
{if ($SITENAME == "PASCACIO" OR $SITENAME == "FACTURASE")}
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=157713104314758";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like-box" data-href="https://www.facebook.com/comprobantedigital?ref=ts" data-width="900" data-show-faces="false" data-stream="true" data-header="false"></div></p>
{/if}
</div>
{include file="boxes/white_close.tpl"}

