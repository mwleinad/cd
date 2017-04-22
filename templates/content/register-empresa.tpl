		       
<div class="formLine" style="width:100%; text-align:left">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Raz&oacute;n Social:</div>
    <input name="razonSocial" id="razonSocial" type="text" value="{$post.razonSocial}" size="50" class="largeInput"/>
</div>

<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Direcci&oacute;n:</div>     
    <input name="calle" id="calle" type="text" value="{$post.calle}" size="50"  class="largeInput"/>    
</div>
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> No. Exterior:</div>
    <div style="float:left"> 
    	<input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="15"  class="largeInput"/>
    </div>
    <div style="float:left; padding:0px 19px 0px 14px;">No. Interior:</div>
    <div style="float:left">
    	<input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="15"  class="largeInput"/>
    </div>
    <div style="clear:both"></div>
</div>
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Colonia:</div>
    <div style="float:left"> 
    	<input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="15"  class="largeInput"/>
    </div>
	<div style="float:left; padding:0px 6px 0px 14px;"><span style="color:#F00">*</span> Localidad:</div>
    <div style="float:left; padding-left:15px">
    	<input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="15"  class="largeInput"/>
    </div>
    <div style="clear:both"></div>
</div>
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> Municipio o Delegaci&oacute;n:</div>
    <div style="float:left">
    	<input name="municipio" id="municipio" type="text" value="{$post.ciudad}" size="15"  class="largeInput"/>
    </div>
    <div style="float:left; padding:0px 6px 0px 14px;"><span style="color:#F00">*</span> Ciudad:</div>
	<div style="float:left; padding-left:32px">
    	<input name="ciudad" id="ciudad" type="text" value="{$post.ciudad}" size="15" class="largeInput"/>
    </div>
    <div style="clear:both"></div>
</div>
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> C&oacute;digo Postal:</div>
    <div style="float:left">
    	<input name="cp" id="cp" type="text" value="{$post.cp}" size="15"  class="largeInput"/>
    </div>
	<div style="float:left; padding:0px 6px 0px 14px;"><span style="color:#F00">*</span> Estado:</div>
    <div style="float:left; padding-left:32px">
    	<input name="estado" id="estado" type="text" value="{$post.estado}" size="15" class="largeInput"/>
    </div>
    <div style="clear:both"></div>
</div> 
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> T&eacute;lefono de la Empresa:</div>
     <div style="float:left">
    	<input name="telefono" id="telefono" type="text" value="{$post.telEmpresa}" size="15" class="largeInput"/>
    </div>
	<div style="float:left; padding:0px 6px 0px 14px;"><span style="color:#F00">*</span> Pa&iacute;s:</div>
    <div style="float:left; padding-left:49px">
    	<input name="pais" id="pais" type="text" value="{$post.pais}" size="15" class="largeInput"/>
    </div>
    <div style="clear:both"></div>
</div> 
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> RFC Y Homoclave:</div>
    <input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="50" class="largeInput"/>
</div> 
<div class="formLine">
	<div style="width:30%;float:left"><span style="color:#F00">*</span> R&eacute;gimen Fiscal:</div>
    <input name="regimenFiscal" id="regimenFiscal" type="text" value="{$post.regimenFiscal}" size="50" class="largeInput"/>
</div>

<span style="color:#F00">*</span> Campos requeridos

<p>Los datos proporcionados serán de uso exclusivo de {$SITENAME|lower|capitalize}, si por motivo alguno se ha confundido en algún dato podrá cambiarlo sin ningún problema una vez estemos dentro del sistema.</p>

<p>Los datos proporcionados podrán modificarlos la/las personas que tengan acceso al sistema.</p>

<p>{$SITENAME|lower|capitalize} no se hace responsable del mal uso que se le dé por parte de los usuarios con acceso  y a ningún cambio que se realicen al sistema.</p>

<p>Para cualquier aclaraci&oacute;n o necesita  solucionar su problema, no dude en comunicarse  con su socio comercial también podrá  enviarnos un correo o llamarnos a los teléfonos de {$SITENAME|lower}, con gusto lo apoyaremos a solucionar sus dudas.</p>

<p><input type="checkbox" name="condicionEmpresa" id="condicionEmpresa" /> <b>Estoy de Acuerdo con los T&eacute;rminos y Condiciones.</b></p>
<p align="right">
	<input type="button" name="btnSigEmp" id="btnSigEmp" class="btnGral" value="Siguiente >>" onclick="SaveEmpresa()" />
</p>