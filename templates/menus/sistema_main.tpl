	<!-- MENU START -->
	<div id="menu">

		<ul class="group" id="menu_group_main">
			<!-- MENU SOLO PARA EL CLIENTE -->
			{if $page == "cliente-factura" || $page == "datos-cliente" || $page == "cliente-consulta"}
				<li class="item first" id="one"><a href="#" class="main current"><span class="outer"><span class="inner dashboard">Cliente</span></span></a>
	  			</li>
			<!-- END MENU SOLO PARA EL CLIENTE -->
			{/if}

			{if in_array("datos_generales",$permisos)}
				<li class="item first" id="eight"><a href="{$WEB_ROOT}/datos-generales" class="main
		  		{if $page == "datos-generales" || $page == "usuarios" || $page == "admin-folios" || $page == "impuesto"}current{/if}"><span class="outer"><span class="inner settings">Configuraci&oacute;n</span></span></a>
				</li>
			{elseif in_array("usuarios",$permisos)}
				<li class="item first" id="eight"><a href="{$WEB_ROOT}/usuarios" class="main
				{if $page == "datos-generales" || $page == "usuarios" || $page == "admin-folios" || $page == "impuesto"}current{/if}"><span class="outer"><span class="inner settings">Configuraci&oacute;n</span></span></a>
				</li>
			{elseif in_array("admin_folios",$permisos)}
				<li class="item first" id="eight"><a href="{$WEB_ROOT}/admin-folios" class="main
		  		{if $page == "datos-generales" || $page == "usuarios" || $page == "admin-folios" || $page == "impuesto"}current{/if}"><span class="outer"><span class="inner settings">Configuraci&oacute;n</span></span></a>
				</li>
			{elseif in_array("impuesto",$permisos)}
				<li class="item first" id="eight"><a href="{$WEB_ROOT}/impuesto" class="main
		  		{if $page == "datos-generales" || $page == "usuarios" || $page == "admin-folios" || $page == "impuesto"}current{/if}"><span class="outer"><span class="inner settings">Configuraci&oacute;n</span></span></a>
				</li>
			{/if}  
      
 			{if in_array("nuevos_productos",$permisos)}
				<li class="item middle" id="five"><a href="{$WEB_ROOT}/compras" class="main
				{if $page == "compras"}current{/if}"><span class="outer"><span class="inner productos">Compras</span></span></a>
				</li>
			{/if}
      
			{if in_array("nueva_venta",$permisos)}
				<li class="item middle" id="six"><a href="{$WEB_ROOT}/nueva-venta" class="main
				{if $page == "nueva-venta"}current{/if}"><span class="outer"><span class="inner ventas">Ventas</span></span></a>
				</li>
			{/if}
      
     
		{if $page != "cliente-factura" && $page != "datos-cliente" && $page != "cliente-consulta"}
    		{*{if $info.moduloEscuela == "Si"}
				<li class="item middle" id="six"><a href="{$WEB_ROOT}/nueva-factura-escuela" class="main
				{if $includedTpl == "nueva-factura-escuela"}current{/if}"><span class="outer"><span class="inner dashboard">CFDi's</span></span></a>
				</li>
    		{else}
				<li class="item middle" id="six"><a href="{$WEB_ROOT}/sistema/nueva-factura" class="main
				{if $includedTpl == "sistema_nueva-factura"}current{/if}"><span class="outer"><span class="inner dashboard">CFDi's</span></span></a>
				</li>
        {/if}*}
			<li class="item middle" id="six"><a href="{$WEB_ROOT}/cfdi33-generate" class="main
				{if $includedTpl == "cfdi33-generate"}current{/if}"><span class="outer"><span class="inner dashboard">CFDi's</span></span></a>
			</li>
		{/if}

				<li class="item last" id="six"><a href="{$WEB_ROOT}/reportePago" class="main
				{if $page == "reportePago"}current{/if}"><span class="outer"><span class="inner soporte">Soporte y Pagos</span></span></a>
				</li>

		</ul>
	</div>
	<!-- MENU END -->
  
  