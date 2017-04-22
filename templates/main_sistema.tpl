<div class="grid_16" id="content">
	<!-- CONTENT TITLE -->
	<div class="grid_9">
		<h1 class="content_edit">
			{if $includedTpl == "datos-generales"}
				Datos Generales de mi Empresa
			{elseif $includedTpl == "sistema_nueva-factura"}
				Crear Nuevo Comprobante
			{elseif $includedTpl == "sistema_consultar-facturas"}
				Consultar Comprobantes
			{elseif $includedTpl == "sistema_consultar-nominas"}
				Reporte de Nomina
			{elseif $includedTpl == "reporte-sat"}
				Generar Reporte SAT
			{elseif $includedTpl == "usuarios"}
				Mis Empleados
			{elseif $includedTpl == "admin-folios_nuevos-folios"}
				Administrar Folios
			{elseif $includedTpl == "admin-folios_actualizar-certificado"}
				Actualizar el Certificado
			{elseif $includedTpl == "admin-productos_nuevos-productos"}
				Administrar Productos
			{elseif $includedTpl == "cliente"}
				Administrar Clientes
			{elseif $includedTpl == "impuesto"}
				Administrar Impuestos
			{elseif $includedTpl == "reporte-ventas"}
				Reporte de Ventas
			{elseif $includedTpl == "sistema"}
				Bienvenido a ComprobantesDigitales
			{elseif $includedTpl == "nueva-venta"}
				Nueva Venta
			{elseif $includedTpl == "actualizar"}
				Por favor proporciona Datos de Contacto
			{elseif $includedTpl == "nomina"}
				Crear Nuevo Recibo de N&oacute;mina 
			{elseif $includedTpl == "addendaPepsico"}
				Crear Nuevo Addenda Pepsico
			{elseif $includedTpl == "soporte"}
				Necesitas ayuda? Genera una nueva solicitud de soporte
			{elseif $includedTpl == "nueva-compra"}
				Sube el XML de tu Proveedor
            {elseif $includedTpl == "xml-pdf"}
				Facturaci&oacute;n > Convertir de Xml a Pdf
			{/if}
		</h1>
	</div>
	<!-- CONTENT TITLE RIGHT BOX -->
	<div class="grid_6" id="eventbox">
		<a href="#" class="inline_tip">
		{if $includedTpl == "datos-generales"}
			Aqu&iacute; puedes agregar sucursales o modificar tus datos fiscales
		{elseif $includedTpl == "sistema_nueva-factura"}
			Aqu&iacute; puedes crear un Nuevos Comprobantes para generar facturas 
		{elseif $includedTpl == "sistema_consultar-facturas"}
			Aqu&iacute; puedes env&iacute;a tus facturas por correo o cons&uacute;ltalas
		{elseif $includedTpl == "sistema_consultar-nominas"}
			Vencimiento: {$vencimiento.venNomina|date_format:"%d/%m/%Y"}
		{elseif $includedTpl == "reporte-sat"}
			En esquema 2010 tienes que enviar reportes mensuales
		{elseif $includedTpl == "usuarios"}
			Aqu&iacute; puedes agrega un nuevo empleado y editar sus permisos
		{elseif $includedTpl == "admin-folios_nuevos-folios"}
			Aqu&iacute; puedes agregar varios folios y series, eliminarlos y editarlos
		{elseif $includedTpl == "admin-folios_actualizar-certificado"}
			Favor de subir un Certificado de tipo Sello Digital, la FIEL NO funciona.
		{elseif $includedTpl == "admin-productos_nuevos-productos"}
			Aqu&iacute; puedes agrega los productos y servicios que ofreces
		{elseif $includedTpl == "cliente"}
			Aqu&iacute; puedes agregar un nuevo Clientes
		{elseif $includedTpl == "impuesto"}
			Si manejas impuestos especiales de Gobierno
		{elseif $includedTpl == "nueva-venta"}
			Aqu&iacute; puedes realizar una nueva ventas sencillas
		{elseif $includedTpl == "nomina"}
			Vencimiento: {$vencimiento.venNomina|date_format:"%d/%m/%Y"}
		{elseif $includedTpl == "addendaPepsico"}
			Aqu&iacute; puedes crear una Nueva Addenda Pepsico para generar  facturas
		{elseif $includedTpl == "actualizar"}
			<a href="{$WEB_ROOT}/privacidad" target="_blank">Aviso de Privacidad</a>
		{elseif $includedTpl == "reporte-ventas"}
			Aqu&iacute; puedes seleccionar uno o mas Tickets para facturar

			
		{/if}</a>
	</div>
	
	<div class="clear"></div>
	<!--    TEXT CONTENT OR ANY OTHER CONTENT START     -->
	<div class="grid_15" id="textcontent">
		{include file="templates/{$includedTpl}.tpl"}	
	</div>-
	<div class="clear"> </div>
	<!-- END CONTENT-->    

</div>