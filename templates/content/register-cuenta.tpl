                <input type="hidden" name="productId" value="v3" {if $plan == "empresarial"}checked{/if} onclick="ShowCfdi()" />
<div class="formLine" style="width:100%; text-align:left">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Correo de Acceso (Usuario):</div>
    <input name="email" id="email" type="text" value="{$post.email}" size="50" class="largeInput"/>
</div>
<div style="clear:both"></div>
<div class="formLine">   
  	<div style="width:30%;float:left"><span style="color:#F00">*</span> Contrase&ntilde;a:</div> 
    <input name="password" id="password" type="password" value="{$post.password}" size="50"  class="largeInput"/>
</div>
<div style="clear:both"></div>

<div class="formLine" style="width:100%; text-align:left">
	<div style="width:30%;float:left">Socio Comercial:</div>
  	<select name="socioId" id="socioId" class="largeInput">
	    <option value="39">Braun Huerin</option>
	    <option value="0">Ninguno</option>
    </option>
    </select>
</div>

<p> <span style="color:#F00">*</span> Campos requeridos</p>

<p>Contará con 14 dias de prueba gratis con 5 folios en sistema EMPRESARIAL Y CORPORATIVO.</p>
<p>La aplicacion le requerira adquirir timbres para poder seguir utilizando el sistema despues de su periodo de prueba.</p>

<p align="right">
	<input type="button" name="btnSig" id="btnSig" class="btnGral" value="Guardar" onclick="SaveRegistro()" />
</p>