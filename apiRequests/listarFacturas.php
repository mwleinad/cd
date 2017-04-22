<html>
<head>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
</head>
<body>
<h2>Listar Facturas</h2>
<form method="post" action="" name="frmFactura" id="frmFactura">
<input type="hidden" id="accion" name="accion" value="listarFacturas">
<label>* Email:</label>
<input type="text" name="usrEmail" id="usrEmail" value="cfdi@facturase.com">
<br>
<label>* Contrase&ntilde;a:</label>
<input type="password" name="passwd" id="passwd" value="facturase">
<br /><br>
<input type="button" onClick="ListarFacturas()" value="Buscar">
</form>

<br><br>

<div id="facturasList"></div>

<p><a href="javascript:history.back(-1)"> Regresar </a></p>

</body>
</html>