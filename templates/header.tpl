<!-- Header Panel start -->
<div id="headerbg">
	<!-- toppan Panel start -->
	<div id="toppan">
		<a href="{$WEB_ROOT}" title="{$SITENAME|lower|capitalize}">
    {if $SITENAME != "CONFACTURA"}
    BraunHuerin
	  {*}  <img src="{$WEB_ROOT}/images/logo.png" alt="PascacioAsociados" height="80" border="0" class="logo" />{*}
    {/if}
    </a> 
		<ul style="color:#000000">
			<li><a href="http://comprobantedigital.mx/sistema/login"  style="color:#000000" title="Inicio"><span>Inicio</span></a></li>
			<li><a href="{$WEB_ROOT}/sistema"  style="color:#000000" title="Mi Sistema"><span>Mi Sistema</span></a></li>
		</ul>
		<br/>
	</div>
	<!-- toppan Panel end -->
	<!-- header Panel start -->
&nbsp;
	<!-- header Panel end -->
</div>
<!-- Header Panel end -->
{if $page == "homepage" || 
  	  $page == "" || 
      $page == "develop" ||
      $page == "negocio" ||
      $page == "faq" ||
      $page == "cbb" ||
      $page == "cfdi" || 
      $page == "servicio" ||
      $page == "servicios" ||
      $page == "capacitaciones" || 
      $page == "register-manual" || 	          
      $page == "beneficios"}
<center>
{*}
<div align="center" style="width:900px; padding-top:10px; height:280px">
	{include file="slider.tpl"}
</div>{*}
</center>
{/if}