<div id="fview" style="display:none;">	
  <div id="fviewload" style="display:block"><img src="{$WEB_ROOT}/images/load.gif" border="0" /></div>
 	<div id="fviewcontent" style="display:none"></div>
</div> 	

<div class="grid_8" id="logo">
	<a href="{$WEB_ROOT}/sistema" style="color:#FFF; text-decoration:none">{if $info.rfc}Braun Huerin - {/if}Comprobantes Digitales.</a>
</div>

<div class="grid_8">
  <!-- USER TOOLS START -->
  <div id="user_tools">
    <span>Bienvenido <a href="#">{$info.email}</a>  |  <a id="logoutDiv" style="cursor:pointer">Salir</a>
    
      <div style="display:inline;color:#FFFF33; background-image:none; text-align:center;">
      | {$info.limite - $info.expedidos} timbres Restantes.
      {$certAboutToExpire}
        </div>
    </span>
  <!-- USER TOOLS END -->
  </div>
</div><!-- grid 8 -->

<div class="grid_16" id="header">
	{include file="menus/sistema_main.tpl"}
</div>

<div class="grid_16">
<!-- TABS START -->
	<div id="tabs">
  	<div class="container">
			{include file="menus/new_main.tpl"}
    </div>
  </div>
<!-- TABS END --> 
{*if $page == "admin-folios" || $page == "impuesto"}
	<div id="tabs" style="background-color:#FFFFFF">
  	<div class="container">
			{include file="menus/new_main2.tpl"}
		</div>
	</div>
{/if*}  
</div>

