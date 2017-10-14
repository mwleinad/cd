{if $includedTpl == "reporte-ventas" ||  $page == "nueva-venta"}
<ul>
		<li><a href="{$WEB_ROOT}/nueva-venta" {if $includedTpl == "nueva-venta"} class="current"{/if}><span>Nueva Venta</span></a></li>
    <li><a href="{$WEB_ROOT}/reporte-ventas" {if $includedTpl == "reporte-ventas"} class="current"{/if}><span>Reporte de Ventas y CxC</span></a></li>

{/if}    



{if $includedTpl == "sistema_nueva-factura" || $page == "nomina" || $page == "nueva-factura-ish" || $page == "addendaPepsico" || $page == "addendaContinental" || $page == "nueva-factura-agrario" || $page == "nueva-factura-escuela" || $page == "nueva-factura-transporte" || $page == "nueva-factura-ieps" || $page == "addendaZepto" || $page == "donatarias" || $includedTpl == "sistema_consultar-facturas" || $includedTpl == "sistema_consultar-nominas" || $page == "cliente" || $page == "cfdi33-generate" || $page == "cfdi33-generate-nomina"}
<ul>


    <li><a href="{$WEB_ROOT}/sistema/nueva-factura" {if $includedTpl == "nueva-factura"} class="current"{/if}><span>Nuevo CFDi</span></a></li>

	<li><a href="{$WEB_ROOT}/cfdi33-generate" {if $includedTpl == "nueva-factura"} class="current"{/if}><span><b>Nuevo CFDi 3.3</b></span></a></li>

    {if $info.moduloEscuela == "Si"}
      {if in_array("nueva_factura",$permisos)}
    <li><a href="{$WEB_ROOT}/nueva-factura-escuela" {if $includedTpl == "nueva-factura-escuela"} class="current"{/if}><span>Nuevo Comprobante Escuela</span></a></li>
    	{/if}
    {/if}  

    {if $info.moduloAgrario == "Si"}
      {if in_array("nueva_factura",$permisos)}
    <li><a href="{$WEB_ROOT}/nueva-factura-agrario" {if $includedTpl == "nueva-factura-agrario"} class="current"{/if}><span>Nuevo Comprobante Agrario</span></a></li>
    	{/if}
    {/if}  

    {if $info.moduloIeps == "Si"}
      {if in_array("nueva_factura",$permisos)}
    <li><a href="{$WEB_ROOT}/nueva-factura-ieps" {if $includedTpl == "nueva-factura-ieps"} class="current"{/if}><span>Nuevo Comprobante IEPS</span></a></li>
    	{/if}
    {/if}  

    {if $info.moduloIsh == "Si"}
      {if in_array("nueva_factura",$permisos)}
	    <li><a href="{$WEB_ROOT}/nueva-factura-ish" {if $includedTpl == "nueva-factura-ish"} class="current"{/if}><span>Nuevo 	Comprobante ISH</span></a></li>
	    {/if}  
    {/if}

    {if $info.moduloNomina == "Si"}
    	{if in_array("nueva_factura",$permisos)}
		<li><a href="{$WEB_ROOT}/sistema/consultar-nominas" {if $includedTpl == "sistema_consultar-nominas"} class="current"{/if}><span>Reporte de N&oacute;mina</span></a></li>
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/nomina" {if $page == "nomina"}class="current"{/if}><span>CFDi N&oacute;mina</span></a>
		</li>
		<li class="item middle" id="seven">
			<a href="{$WEB_ROOT}/cfdi33-generate-nomina" {if $page == "nomina"}class="current"{/if}><span>CFDi N&oacute;mina 3.3</span></a>
		</li>
        {/if}
    {/if}

    {if $info.addendaPepsico == "Si"}
    	{if in_array("nueva_factura",$permisos)}
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/addendaPepsico" {if $page == "addendaPepsico"}class="current"{/if}><span>Addenda Pepsico</span></a>
		</li>
        {/if}
    {/if}

    {if $info.addendaContinental == "Si"}
    	{if in_array("nueva_factura",$permisos)}
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/addendaContinental" {if $page == "addendaContinental"}class="current"{/if}><span>Addenda Continental</span></a>
		</li>
        {/if}
    {/if}

    {if $info.addendaZepto == "Si"}
    	{if in_array("nueva_factura",$permisos)}
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/addendaZepto" {if $page == "addendaZepto"}class="current"{/if}><span>Addenda Alcatel</span></a>
		</li>
        {/if}
    {/if}

    {if $info.donatarias == "Si"}
    	{if in_array("nueva_factura",$permisos)}
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/donatarias" {if $page == "donatarias"}class="current"{/if}><span>Recibo Donatarias</span></a>
		</li>
        {/if}
    {/if}

	<li><a href="{$WEB_ROOT}/sistema/consultar-facturas" {if $includedTpl == "sistema_consultar-facturas"} class="current"{/if}><span>Reporte de Comprobantes</span></a></li>

    <li><a href="{$WEB_ROOT}/cliente" {if $page == "cliente"} class="current"{/if}><span>Clientes</span></a></li>

  
</ul>
{/if}

<ul>
{if $page == "datos-generales" || $page == "usuarios" || $page == "admin-folios" || $page == "impuesto" || $page == "vencimientos" || $page == "actualizar" || $page == "vencimientos"}
<ul>
	{if in_array("datos_generales",$permisos)}
    <li class="item middle" id="eight">
    	<a href="{$WEB_ROOT}/datos-generales" {if $page == "datos-generales"}class="current"{/if}><span>Mi Empresa</span></a>
    </li>
    {/if}
    {if in_array("usuarios",$permisos)}
    <li class="item middle" id="four">
    	<a href="{$WEB_ROOT}/usuarios" {if $page == "usuarios"}class="current"{/if}><span>Empleados</span></a>
	</li>
    {/if}
    {if in_array("nuevos_folios",$permisos)}
    <li class="item middle" id="two">
    	<a href="{$WEB_ROOT}/admin-folios/nuevos-folios" {if $includedTpl == "admin-folios_nuevos-folios"}class="current"{/if}><span>Folios</span></a>
    </li>

		<li><a href="{$WEB_ROOT}/admin-folios/actualizar-certificado" {if $includedTpl == "admin-folios_actualizar-certificado"} class="current"{/if}><span>Actualizar Certificado</span></a></li>

    {/if}
    
    
    {if $info.moduloImpuestos == "Si"}
    	{if in_array("impuesto",$permisos)}
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/impuesto" {if $page == "impuesto"}class="current"{/if}><span>Impuestos</span></a>
		</li>
        {/if}
    {/if}
    
		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/vencimientos" {if $page == "vencimientos"}class="current"{/if}><span>Vencimientos</span></a>
		</li>

		<li class="item middle" id="seven">
        	<a href="{$WEB_ROOT}/actualizar" {if $page == "actualizar"}class="current"{/if}><span>Datos Contacto</span></a>
		</li>
    
</ul>
{/if}

{if $page == "admin-productos" || $includedTpl == "nueva-compra"  || $includedTpl == "proveedores"  || $page == "compras"}
<ul>
    <li><a href="{$WEB_ROOT}/compras" {if $page == "compras"} class="current"{/if}><span>Reporte de Compras y CxP</span></a></li>

	<li><a href="{$WEB_ROOT}/nueva-compra" {if $includedTpl == "nueva-compra"} class="current"{/if}><span>Nueva Compra o Gasto</span></a></li>
    <li><a href="{$WEB_ROOT}/admin-productos/nuevos-productos" {if $page == "admin-productos"} class="current"{/if}><span>Inventario de Productos</span></a></li>
    <li><a href="{$WEB_ROOT}/proveedores" {if $page == "proveedores"} class="current"{/if}><span>Proveedores y Acreedores</span></a></li>
</ul>
{/if}

{if $page == "reportePago" || $includedTpl == "videos"}
<ul>
    <li><a href="{$WEB_ROOT}/videos" {if $page == "videos"} class="current"{/if}><span>Videos Tutoriales</span></a></li>
    <li><a href="{$WEB_ROOT}/reportePago" {if $page == "reportePago"} class="current"{/if}><span>Renovacion y Adquisicion de Timbres</span></a></li>
</ul>
{/if}



<!-- CLIENTE -->
{if $page == "cliente-factura" || $page == "datos-cliente" || $page == "cliente-consulta"}
<ul>
	<li>
    	<a href="{$WEB_ROOT}/datos-cliente" {if $page == "datos-cliente"} class="current"{/if}>
        	<span>Datos del Cliente</span>
		</a>
	</li>
    <li>
    	<a href="{$WEB_ROOT}/cliente-factura" {if $page == "cliente-factura"} class="current"{/if}>
        	<span>Facturar Ticket</span>
		</a>
	</li>
    <li>
    	<a href="{$WEB_ROOT}/cliente-consulta" {if $page == "cliente-consulta"} class="current"{/if}>
        	<span>Consultar Comprobantes</span>
		</a>
	</li>
</ul>
{/if}
<!-- END CLIENTE -->