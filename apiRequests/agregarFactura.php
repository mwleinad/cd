<html>
<head>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
<h2>Nueva Factura</h2>
<form method="post" action="" name="frmFactura" id="frmFactura">
<input type="hidden" id="accion" name="accion" value="agregarFactura">
<input type="hidden" id="tipo" name="tipo" value="">
<label>* Email:</label>
<input type="text" name="usrEmail" id="usrEmail" value="cfdi@facturase.com">
<br>
<label>* Contrase&ntilde;a:</label>
<input type="password" name="passwd" id="passwd" value="facturase">
<br /><br>
<label>* RFC Receptor:</label>
<input type="text" name="rfcReceptor" id="rfcReceptor" value="LOAD850511SX3">
<br />
<label>* Forma de Pago:</label>
<input type="text" name="formaDePago" id="formaDePago" value="Una Sola Exhibicion">
<br />
<label>* Metodo de Pago:</label>
<input type="text" name="metodoDePago" id="metodoDePago" value="No Identificado">
<br />
<label>Num. Cta. Pago:</label>
<input type="text" name="NumCtaPago" id="NumCtaPago" value="No Identificado">
<br />
<label>Condiciones de Pago:</label>
<input type="text" name="condicionesDePago" id="condicionesDePago" value="Cheque">
<br />

<label>* Tipo Comprobante:</label>
<input type="text" name="tipoComprobante" id="tipoComprobante" value="Factura">
<br />
<label>* Sucursal (Identificador):</label>
<input type="text" name="sucursal" id="sucursal" value="Matriz">
<br />
<label>* Serie:</label>
<input type="text" name="serie" id="serie" value="NORTE">
<br />
<label>Observaciones:</label>
<input type="text" name="observaciones" id="observaciones" value="Mis observaciones">
<br />
<label>* Tasa Iva:</label>
<input type="text" name="tasaIva" id="tasaIva" value="16">
<br />
<label>* Tipos de Moneda:</label>
<input type="text" name="tiposDeMoneda" id="tiposDeMoneda" value="MXN">
<br />
<label>Tipos de Cambios:</label>
<input type="text" name="tiposDeCambio" id="tiposDeCambio" value="1">
<br />

<label>Descuento:</label>
<input type="text" name="porcentajeDescuento" id="porcentajeDescuento" value="0">
<br />
<label>Ret. IVA.:</label>
<input type="text" name="porcentajeRetIva" id="porcentajeRetIva" value="0">
<br />
<label>% Ret. ISR.:</label>
<input type="text" name="porcentajeRetIsr" id="porcentajeRetIsr" value="0">
<br />
<label>% Ret. IEPS:</label>
<input type="text" name="porcentajeRetIEPS" id="porcentajeRetIEPS" value="0">
<br />

<input type="button" onClick="AgregarFactura('F')" value="Factura">
<input type="button" onClick="AgregarFactura('V')" value="Vista Previa">
</form>
<p><a href="javascript:history.back(-1)"> Regresar </a></p>
</body>
</html>