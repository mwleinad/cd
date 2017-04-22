		       
<div class="formLine" style="width:100%; text-align:left">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Nombre del contacto de la empresa:</div>
    <input name="nombre" id="nombre" type="text" value="{$post.nombre}" size="50" class="largeInput"/>
</div>

<div class="formLine">   
  	<div style="width:30%;float:left"><span style="color:#F00">*</span> RFC de la empresa (Este sera su usuario): </div> 
    <input name="email" id="email" type="text" value="{$post.email}" size="50" class="largeInput"/>
</div>
<div class="formLine">
  	<div style="width:30%;float:left"><span style="color:#F00">*</span> Tel&eacute;fono de la empresa:</div>
    <input name="telPersonal" id="telPersonal" type="text" value="{$post.telPersonal}" size="50"  class="largeInput"/>
</div> 
<div class="formLine">
  	<div style="width:30%;float:left">Tel&eacute;fono Personal:</div>
    <input name="celular" id="celular" type="text" value="{$post.celular}" size="50"  class="largeInput"/>
</div>

{*}
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> RFC Y Homoclave:</div>
    <input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="50" class="largeInput"/>
</div> 
{*}
<div style="clear:both"></div>
<div class="formLine">   
  	<div style="width:30%;float:left"><span style="color:#F00">*</span> Contrase&ntilde;a:</div> 
    <input name="password" id="password" type="password" value="{$post.password}" size="50"  class="largeInput"/>
</div>


<p> <span style="color:#F00">*</span> Campos requeridos</p>

<p>Los datos proporcionados únicamente serán utilizados para verificar la veracidad de una solicitud <br />
Importante; únicamente la persona que brinda estos datos podrá solicitar información de acceso a su sistema o solicitar cambios y ajustes.
</p>

<p><input type="checkbox" name="condicionPersonal" id="condicionPersonal" value="1" /> <b>Estoy de Acuerdo con los T&eacute;rminos y Condiciones</b></p>
<p align="right">
<input type="button" name="btnSigPer" id="btnSigPer" class="btnGral" value="Registar Cuenta" onclick="SaveRegistro()" />
</p>