<?php

include_once("init.php");
include_once("config.php");

echo '<h2>Menu</h2>';
echo '<br>';
echo '<a href="'.WEB_ROOT.'/agregarFactura.php">Agregar Facturas</a>';
echo '<br>';
echo '<a href="'.WEB_ROOT.'/cancelarFactura.php">Cancelar Factura</a>';
echo '<br>';
echo '<a href="'.WEB_ROOT.'/listarFacturas.php">Listar Facturas</a>';
echo '<br>';
echo '<a href="'.WEB_ROOT.'/verFactura.php">Ver Factura</a>';

?>