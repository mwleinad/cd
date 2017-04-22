<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12054476-17']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
{*<script>
  window.intercomSettings = {ldelim}
    app_id: "ryaqinks",
    name: "{if !$user.razonSocial}{$user.nombrePer}{elseif $user.razonSocial}{$user.razonSocial}{else}{$user.empresaId}{/if}", // Full name
    email: "{$user.emailPer}", // Email address
    created_at: {$user.activadoEl|strtotime}, // Signup date as a Unix timestamp
  {rdelim}; 
</script>*}

{literal}
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/ryaqinks';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
{/literal}

{if $page == "homepage" && $SITENAME == "CONFACTURA"}
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Description" content="Avantika, pioneros en la facturación electrónica."/>
<meta name="Keywords" content="facturacion electronica, folios para facturación electronica"/>

<title>Avantika. Software de facturación electrónica por folios CFDI y CBB. ¡Prueba gratis!</title>
<link href="css/facturacion.css" rel="stylesheet" type="text/css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="javascript/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="javascript/jquery.bxSlider.min.js" type="text/javascript"></script>
<script src="javascript/functions.js" type="text/javascript"></script>
<script src="javascript/js-config.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}

   $(function(){ 
	 

        $('#slideshow').bxSlider({
			speed: 700,
			pause: 8000,			       
			auto: true,
			infiniteLoop: true 
		});
     });
	 
</script>
<script language="javascript" type="text/javascript">
function validar(nombre,correo,telefono,mensaje)
{
	if(nombre==''||correo==''||telefono==''||mensaje=='')
	{
		alert('Por favor, llene todos los campos');
		return false;
	}
	else if(nombre!=''||correo!=''||telefono!=''||mensaje!='')
	{
		alert('Gracias por escribirnos. En breve lo contactaremos');
		return true;
	}	
} 

</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-12518871-37', 'avantika.com.mx');
  ga('send', 'pageview');

</script>
{/literal}
{/if}

{if $page == "plan-negocios" || 
	$page == "integracion" || 
    $page == "beneficios" || 
    $page == "terminos" || 
    $page == "privacidad" || 
    $page == "faq" ||
    $page == "cbb" ||
    $page == "cfdi" ||
    $page == "servicio" ||
    $page == "servicios" || 
    $page == "capacitaciones" || 
    $page == "register-manual" || 
    $page == "negocio"}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{else}
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
{/if}


{if $SITENAME != "CONFACTURA"}
<title>Comprobantes Fiscales :: Paquetes de Comprobantes Fiscales Digitales Para Tu Empresa
{if $page == "homepage"} :: Inicio {/if}
{if $page == "producto"} :: Nuestro Producto {/if}
{if $page == "portfolio"} :: Nuestros Clientes {/if}
{if $page == "contacto"} :: Nuestros Proveedores  {/if}
{if $page == "register-manual"} :: Registro de nuevo Usuario. {/if}
{if $page == "beneficios"} :: Beneficios de {$SITENAME|lower|capitalize}. {/if}
{if $page == "terminos"} :: Terminos y Condiciones {/if}
{if $page == "privacidad"} :: Aviso de Privacidad. {/if}
{if $page == "negocio"} :: Haz Negocio. {/if}
{if $page == "cbb"} :: Facturacion Electronica con Codigo de Barras Bidimencional. {/if}
{if $page == "cfdi"} :: Facturacion Electronica, 1 mes gratis! {/if}
{if $page == "servicio"} :: Prueba nuestra Demo. {/if}
{if $page == "servicios"} :: Addendas. {/if}
{if $page == "capacitaciones"} :: Entrenamientos y Capacitaciones. {/if}
{if $page == "faq"} :: Preguntas Frecuentes de Nuestro servicio de Facturacion Electronica. {/if}
</title>
{/if}

<meta name="description" content="Comprobantes Fiscales :: Comprobantes Fiscales Digitales Para tu Empresa
{if $page == "homepage"} :: Inicio {/if}
{if $page == "producto"} :: Conoce Nuestro Producto y Obten un mes gratis! {/if}
{if $page == "portfolio"} :: Nuestros clientes, nuestra razon de ser. Conviertete en parte de la familia {/if}
{if $page == "contacto"} :: Contacta a cualquiera de nuestros distribudores y seras atendido en menos de 24 horas. Ademas recibe ofertas especiales  {/if} 
{if $page == "register-manual"} :: Registrate ahora, recibe un mes gratis y 10 timbres en CFDi o Folios Ilimitados en CBB. {/if}
{if $page == "beneficios"} :: 5 años de experiencia nos respaldan. Somos resellers autorizados. {/if}
{if $page == "terminos"} :: Tu informacion esta segura con nosotros. {/if}
{if $page == "privacidad"} :: Tu informacion esta segura con nosotros. {/if}
{if $page == "negocio"} :: Se parte de nuestra negocio y obten los mejores ingresos!. {/if}
{if $page == "cbb"} :: Facturacion con Codigo de Barras Bidimensionales. {/if}
{if $page == "cfdi"} :: Te regalamos 1 mes y 10 folios de Facturacion Electronica. {/if}
{if $page == "servicio"} :: Prueba nuestra demo y enterate de todo lo que ofrecemos. {/if}
{if $page == "servicios"} :: Necesitas otros servicios, tambien manejamos addendas y campos especiales. {/if}
{if $page == "capacitaciones"} :: Entrenamientos en Factura Electronica, manejamos grupos y precios especiales. {/if}
{if $page == "faq"} :: Preguntas Frecuentes de Nuestro servicio de Facturacion Electronica. {/if}
"/>
<meta name="keywords" content="Comprobantes Fiscales, Comprobantes Fiscales Digitales, Comprobante Fiscal Digital, Comprobante Digital Fiscal, Comprobante Fiscales"  />




{if $page == "" || 
	($page == "homepage" && $SITENAME != "CONFACTURA") || 
    $page == "producto" || 
    $page == "portfolio" || 
    $page == "contacto" || 
    $page == "register-manual" || 
    $page == "develop" ||
    $page == "beneficios" ||
    $page == "terminos" ||
    $page == "privacidad" ||
    $page == "negocio" ||
    $page == "cbb" ||
    $page == "cfdi" ||
    $page == "servicio" ||
    $page == "servicios" || 
    $page == "capacitaciones" ||      
    $page == "faq"}
	<link href="{$WEB_ROOT}/css/style3.css" rel="stylesheet" type="text/css"  />
    {if $page == "producto"}
		<style>
        body{
            font:normal 13px/22px Verdana, Arial, Helvetica, sans-serif;
            color:#959595;
            background-color: #111113;
            padding:0;
            margin:0;
            overflow: scroll;
                background:url('http://www.facturase.com/2/HTML/assets/background3.jpg') 50% 90px repeat-x;;
        }
        </style>    
    {/if}
{/if}

{if $page == "register-manual"}
<link href="{$WEB_ROOT}/css/forms.css" rel="stylesheet" type="text/css"  />
{/if}

{if $page == "login" || $page == "acceso-cliente"}
	<link href="{$WEB_ROOT}/css/960.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/reset.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/text.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/login.css" rel="stylesheet" type="text/css" media="all" />
{/if}

{if 
	$page == "sistema" ||
  $page == "addendaContinental" || 
  $page == "datos-generales" || 
  $page == "proveedores" || 
  $page == "soporte" || 
  $page == "timbres" || 
  $page == "compras" || 
  $page == "videos" || 
  $page == "nueva-compra" || 
  $page == "usuarios" || 
	$page == "admin-folios" || 
	$page == "admin-productos" || 
	$page == "cliente" || 
	$page == "impuesto" || 
	$page == "activar" || 
	$page == "actualizar" || 
	$page == "reportePago" || 
	$page == "reporte-sat" ||
    $page == "nueva-venta" ||
    $page == "nueva-factura-agrario" ||
    $page == "nueva-factura-escuela" ||
    $page == "nueva-factura-ish" ||
    $page == "nueva-factura-ieps" ||
    $page == "nueva-factura-transporte" ||
    $page == "reporte-ventas" ||
    $page == "cliente-factura" ||
	  $page == "datos-cliente" ||
    $page == "registro-cliente" ||
    $page == "xml-pdf" ||
    $page == "cancelar-uuid" ||
    $page == "nomina" ||
    $page == "donatarias" ||
    $page == "vencimientos" ||
    $page == "cfdi33-generate" ||
    $page == "cliente-consulta"}
	<link href="{$WEB_ROOT}/css/960.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/reset.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/text.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/blue.css" rel="stylesheet" type="text/css" media="all" />
	<link href="{$WEB_ROOT}/css/smoothness/ui.css" type="text/css" rel="stylesheet" />  
{/if}
{if ($page == "homepage" && $SITENAME != "CONFACTURA") || 	
    $page == "beneficios" ||
    $page == "terminos" ||
    $page == "negocio" ||
    $page == "cbb" ||
    $page == "cfdi" ||
    $page == "servicio" ||
    $page == "servicios" ||
    $page == "capacitaciones" || 
    $page == "register-manual" || 
    $page == "faq"}   	
        <link href="{$WEB_ROOT}/DDSlider.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="{$WEB_ROOT}/js/jquery.min.js"></script>
        <script type="text/javascript" src="{$WEB_ROOT}/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="{$WEB_ROOT}/js/jquery.DDSlider.js"></script>
        <script type="text/javascript">
		
  	 	jQuery.noConflict();

        jQuery(document).ready(function() {
            
            jQuery('#yourSliderId').DDSlider({
				
				nextSlide: '.slider_arrow_right',
				prevSlide: '.slider_arrow_left',
				selector: '.slider_selector'
				});
        });
        </script>
{/if}

<script type="text/javascript" src="{$WEB_ROOT}/javascript/prototype.js"></script>
<script src="{$WEB_ROOT}/javascript/scoluos/src/scriptaculous.js" type="text/javascript"></script>
<script src="{$WEB_ROOT}/javascript/datetimepicker.js" type="text/javascript"></script>

<script src="{$WEB_ROOT}/javascript/js-config.js" type="text/javascript"></script>
<script src="{$WEB_ROOT}/javascript/util.js" type="text/javascript"></script>

<script src="{$WEB_ROOT}/javascript/functions.js" type="text/javascript"></script>
<script src="{$WEB_ROOT}/javascript/clearbox.js" type="text/javascript"></script>
<script src="{$WEB_ROOT}/javascript/{$page}.js" type="text/javascript"></script>



<script src="{$WEB_ROOT}/javascript/flowplayer-3.2.4.min.js" type="text/javascript"></script>

{if $section == 'consultar-facturas' || $section == 'consultar-nominas'}
<script src="{$WEB_ROOT}/javascript/{$section}.js" type="text/javascript"></script>
{/if}

<script type="text/javascript" src="{$WEB_ROOT}/javascript/modalbox.js"></script>
<link rel="stylesheet" href="{$WEB_ROOT}/javascript/modalbox.css" type="text/css" media="screen" />

<script>
{if ($page == "activar")}
{literal}
document.observe("dom:loaded", function() {
	Modalbox.show($('testmodal'), {title: "Renovacion", width: 600}); 
});
{/literal}
{/if}
{if ($section == "nueva-factura"&& $renew)}
{literal}
document.observe("dom:loaded", function() {
	Modalbox.show($('testmodal'), {title: "Renovacion", width: 600}); 
});
{/literal}
{/if}


</script>

{if ($page == "register-manual")}
{literal}
<!-- Facebook Conversion Code for tuguchis 1 -->
<script>

(function() {
	
	console.log("jere");
	
	
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6025321891664', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6025321891664&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
{/literal}
{/if}
</head>
<body>

<div id="fb-root"></div>

<div style="position:relative" id="divStatus"></div>




{if $page == "homepage" && $SITENAME == "CONFACTURA"}
	{include file="landingpage.tpl"}
{/if}

{if $page == "" || 
	($page == "homepage" && $SITENAME != "CONFACTURA") ||
    $page == "producto" ||
    $page == "portfolio" ||
    $page == "contacto" ||
    $page == "register-manual" ||
    $page == "develop" ||
    $page == "beneficios" ||
    $page == "terminos" ||
    $page == "privacidad" ||
    $page == "negocio" ||
    $page == "cbb" ||
    $page == "cfdi" ||
    $page == "servicio" ||
    $page == "servicios" || 
    $page == "capacitaciones" ||   
    $page == "faq"}
	{include file="header.tpl"}
	{include file="bottom.tpl"}
	{include file="footer.tpl"}
{/if}
{if $page == "login"}
	{include file="login.tpl"}
{/if}
{if $page == "acceso-cliente"}
	{include file="acceso-cliente.tpl"}
{/if}
{if 
	$page == "addendaZepto" || 
  $page == "donatarias" ||
	$page == "proveedores" || 
	$page == "soporte" || 
	$page == "timbres" || 
	$page == "compras" || 
	$page == "videos" || 
	$page == "nueva-compra" || 
	$page == "addendaContinental" || 
	$page == "addendaPepsico" || 
  $page == "nomina" || 
	$page == "sistema" || 
	$page == "datos-generales" || 
	$page == "usuarios" || 
	$page == "admin-folios" || 
	$page == "admin-productos" || 
	$page == "cliente" || 
	$page == "activar" || 
	$page == "reportePago" || 
	$page == "actualizar" ||
    $page == "vencimientos" ||
    $page == "cfdi33-generate" ||
	$page == "impuesto" || 
  $page == "reporte-sat" ||
  $page == "nueva-venta" ||
  $page == "nueva-factura-ish" ||
  $page == "nueva-factura-agrario" ||
  $page == "nueva-factura-escuela" ||
  $page == "nueva-factura-ieps" ||
  $page == "nueva-factura-transporte" ||
  $page == "reporte-ventas" ||
  $page == "cliente-factura" ||
  $page == "datos-cliente" ||
  $page == "registro-cliente" ||
  $page == "xml-pdf" ||
  $page == "cancelar-uuid" ||
  $page == "cliente-consulta" ||
  $page == "confactura" ||
  $page == "confactura-precios"}
<div class="container_16" id="wrapper">
	{include file="header_sistema.tpl"}
{if $SITENAME != "CONFACTURA" && $info.empresaId != 198}
<div style="position:relative">
</div>
{/if}
  
	{include file="main_sistema.tpl"}
<div class="clear"> </div>
</div>
<!-- WRAPPER END -->
	{include file="footer_sistema.tpl"}
{/if}
</body>
</html>
