{include file="boxes/white_open.tpl"}
<div style="text-align:center; color:#00C; font-weight:bold">
</div>
{include file="menus/admin_folios.tpl"}

<div style="text-align:center; color:#FF0000">
{foreach from=$error item=item}
	{$item}<br />
{/foreach}
</div>

<div style="text-align:center; color:#060">
{foreach from=$success item=item}
	{$item}<br />
{/foreach}
</div>

{include file="forms/reportePago.tpl"}

<div style="text-align:center; color:#00C; font-weight:bold">

{if !$info.rfc}

	<p>&raquo; Pagar con Paypal: </p>
  
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="dlopez@trazzos.com">
<input type="hidden" name="lc" value="MX">
<input type="hidden" name="item_name" value="Timbres Fiscales">
<input type="hidden" name="item_number" value="2">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="MXN">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
<table width="100%">
<tr><td><input type="hidden" name="on0" value="Timbres Fiscales">Timbres Fiscales</td></tr><tr><td><select name="os0">
	<option value="50">50 Timbres $400.00 MXN</option>
	<option value="100">100 Timbres $700.00 MXN</option>
	<option value="150">150 Timbres $900.00 MXN</option>
	<option value="200">200 Timbres $1,200.00 MXN</option>
	<option value="300">300 Timbres $1,300.00 MXN</option>
	<option value="500">500 Timbres $1,500.00 MXN</option>
	<option value="1000">1000 Timbres $2,500.00 MXN</option>
	<option value="1500">1500 Timbres $3,000.00 MXN</option>
	<option value="2000">2000 Timbres $3,600.00 MXN</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="MXN">
<input type="hidden" name="option_select0" value="50">
<input type="hidden" name="option_amount0" value="400.00">
<input type="hidden" name="option_select1" value="100">
<input type="hidden" name="option_amount1" value="700.00">
<input type="hidden" name="option_select2" value="150">
<input type="hidden" name="option_amount2" value="900.00">
<input type="hidden" name="option_select3" value="200">
<input type="hidden" name="option_amount3" value="1200.00">
<input type="hidden" name="option_select4" value="300">
<input type="hidden" name="option_amount4" value="1300.00">
<input type="hidden" name="option_select5" value="500">
<input type="hidden" name="option_amount5" value="1500.00">
<input type="hidden" name="option_select6" value="1000">
<input type="hidden" name="option_amount6" value="2500.00">
<input type="hidden" name="option_select7" value="1500">
<input type="hidden" name="option_amount7" value="3000.00">
<input type="hidden" name="option_select8" value="2000">
<input type="hidden" name="option_amount8" value="3600.00">
<input type="hidden" name="option_index" value="0">
<input type="image" src="https://www.paypalobjects.com/en_US/MX/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
{/if}

<span style="font-size:14px">Datos Bancarios</span>
{if $info.rfc}
<br />
Nombre              BRAUN HUERIN ADMINISTRACION S.A DE C.V. <br />
Banco                  Banamex <br />
Cuenta                8158768      <br />
Sucursal              7010<br />
Clabe                   002180701081587688   <br />
</p>

{else}
<div style="clear:both"></div>

<div style="float:left; width:400px; text-align:center; padding:10px">
	<img src="{$WEB_ROOT}/images/bancos/bancomer.png" /><br />
  A nombre de:Samuel Hernandez Toledo.	<br />
  Cuenta: 0464051785	<br />
  CLABE:012107004640517853<br />
</div>

<div style="float:left; width:400px; text-align:center; padding:10px">
	<img src="{$WEB_ROOT}/images/bancos/oxxo.png" /><br />
  A nombre de:Samuel Hernandez Toledo.	<br />
  Tarjeta: 4555103002300922	<br />
</div>

<div style="float:left; width:400px; text-align:center; padding:10px">
	<img src="{$WEB_ROOT}/images/bancos/paypal.png" /><br />
	<p>Paypal: dlopez@trazzos.com</p>
</div>

<div style="float:left; width:400px; text-align:center; padding:10px">
	Datos de Contacto<br />
	comprobantefiscal@braunhuerin.com.mx<br />
	<p>WhatsApp: 961 25 44 731. <br />Atencion Daniel Lopez Pascacio<br />
</div>

{/if}
</div>

{include file="boxes/white_close.tpl"}

