<style>
/*******************************************************************************
  FORMS
*******************************************************************************/
form label { display:block !important; line-height:normal !important; margin: 5px 0px;  font-size:12px;	font-weight:bold; }
input[type=text] { display:block !important; }
textarea { display:block; }
.smallInput { padding:3px 3px; border:1px solid #999; background:#FFFFE6; font-size:12px !important; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif !important; color: #333 !important; font-style:italic; }
.largeInput { padding:6px 5px; border:1px solid #999; background:#FFFFE6; font-size:15px !important; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif !important; color: #333 !important; }
form .small { width:150px; }
form .medium { width:350px; }
form .wide { width:883px; }
form .wide2 { width:670px; }
.button {
  margin: 0px;
  padding: 0px !important;
  border: 0px;
  background: transparent url('../images/but_right_blue.gif') no-repeat scroll top right;
  color: #1b486a;
  display: block;
  float: left;
  height: 29px;
  margin-right: 6px;
  margin-top:10px;
  padding-right: 12px !important;
  text-decoration: none;
  overflow: hidden;
  font-size: 12px;
  outline: none !important;
  cursor: pointer;
  font-weight: bold;
}
.button span {
  background: url('../images/but_left_blue.gif') no-repeat left top;
  display: block;
  line-height: 29px;
  padding: 0px 0px 0px 12px;
  outline: none !important;
  float:left;
}
.button:hover {
  background-position: right bottom;
  text-decoration:none !important
}
.button:hover span {
  background-position: left bottom;
  color: #1b486a;
}
.button_grey {
  margin: 0px;
  padding: 0px !important;
  border: 0px;
  background: transparent url('../images/but_right_grey.gif') no-repeat scroll top right;
  color: #555;
  display: block;
  float: left;
  height: 30px;
  margin-right: 6px;
  margin-top:10px;
  padding-right: 12px !important;
  text-decoration: none;
  overflow: hidden;
  font-size: 12px;
  outline: none !important;
  cursor: pointer;
  font-weight: bold;	
}
.button_grey span {
  background: url('../images/but_left_grey.gif') no-repeat left top;
  display: block;
  line-height: 30px;
  padding: 0px 0px 0px 12px;
  outline: none !important;
  float:left;
}
.button_grey:hover {
  background-position: right bottom;
  text-decoration:none !important
}
.button_grey:hover span {
  background-position: left bottom;
  color: #333;
}
.button_ok {
  margin: 0px;
  padding: 0px !important;
  border: 0px;
  background: transparent url('../images/but_round_span_blue.gif') no-repeat scroll top right;
  color: #1b486a;
  display: block;
  float: left;
  height: 30px;
  margin-right: 6px;
  margin-top:10px;
  padding-right: 15px !important;
  text-decoration: none;
  overflow: hidden;
  font-size: 12px;
  outline: none !important;
  cursor: pointer;
  font-weight: bold;
}
.button_ok span {
  background: url('../images/but_round_ok_blue.gif') no-repeat left top;
  display: block;
  line-height: 30px;
  padding: 0px 0px 0px 35px;
  outline: none !important;
  float:left;
}
.button_ok:hover {
  background-position: right bottom;
  text-decoration:none !important
}
.button_ok:hover span {
  background-position: left bottom;
  color: #1b486a;
}
.button_notok {
  margin: 0px;
  padding: 0px !important;
  border: 0px;
  background: transparent url('../images/but_round_span_blue.gif') no-repeat scroll top right;
  color: #1b486a;
  display: block;
  float: left;
  height: 30px;
  margin-right: 6px;
  margin-top:10px;
  padding-right: 15px !important;
  text-decoration: none;
  overflow: hidden;
  font-size: 12px;
  outline: none !important;
  cursor: pointer;
  font-weight: bold;
}
.button_notok span {
  background: url('../images/but_round_del_blue.gif') no-repeat left top;
  display: block;
  line-height: 30px;
  padding: 0px 0px 0px 35px;
  outline: none !important;
  float:left;
  font-style: italic;
}
.button_notok:hover {
  background-position: right bottom;
  text-decoration:none !important
}
.button_notok:hover span {
  background-position: left bottom;
  color: #1b486a;
}
.button_grey_round {
  margin: 0px;
  padding: 0px !important;
  border: 0px;
  background: transparent url('../images/but_round_span_grey.gif') no-repeat scroll top right;
  color: #555;
  display: block;
  float: left;
  height: 30px;
  margin-right: 6px;
  margin-top:10px;
  padding-right: 12px !important;
  text-decoration: none;
  overflow: hidden;
  font-size: 12px;
  outline: none !important;
  cursor: pointer;
  font-weight: bold;	
}
.button_grey_round span {
  background: url('../images/but_round_left_grey.gif') no-repeat left top;
  display: block;
  line-height: 30px;
  padding: 0px 0px 0px 12px;
  outline: none !important;
  float:left;
}
.button_grey_round:hover {
  background-position: right bottom;
  text-decoration:none !important
}
.button_grey_round:hover span {
  background-position: left bottom;
  color: #333;
}
</style>
<div id="divForm" style="color:#000000">
	<form id="registerForm" name="registerForm" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Nombre Completo o Raz&oacute;n Social:</div><input name="razonSocial" id="razonSocial" type="text" value="{$post.razonSocial}" size="50" class="largeInput"/>
      </div>
       <div class="formLine">
       		Direcci&oacute;n:<br />
          <div style="width:40%;float:left">Calle: <input name="calle" id="calle" type="text" value="{$post.calle}" size="40"  class="largeInput"/></div>
          <div style="width:30%;float:left">No. Exterior: <input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="30"  class="largeInput"/></div> 
          <div style="width:30%;float:left">No. Interior: <input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="30"  class="largeInput"/></div> 
          <div style="clear:both"></div>
          <br />
          
          <div style="width:40%;float:left">Referencia: <input name="referencia" id="referencia" type="text" value="{$post.referencia}" size="40"  class="largeInput"/></div>
          <div style="width:30%;float:left">Colonia: <input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="30"  class="largeInput"/></div>
          <div style="width:30%;float:left">Localidad: <input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="30"  class="largeInput"/></div> <br />
          
          <div style="clear:both"></div>
          <br />

          <div style="width:40%;float:left">Municipio o Delegaci&oacute;n:  <input name="municipio" id="municipio" type="text" value="{$post.ciudad}" size="40"  class="largeInput"/></div>
          
          <div style="width:30%;float:left">Ciudad: <input name="ciudad" id="ciudad" type="text" value="{$post.ciudad}" size="30"   class="largeInput"/></div> 
          <div style="width:30%;float:left">CP: <input name="cp" id="cp" type="text" value="{$post.cp}" size="30"  class="largeInput"/></div>
          
         	<div style="clear:both"></div>
          <br />
          
          <div style="width:40%;float:left">Estado: <input name="estado" id="estado" type="text" value="{$post.estado}" size="40" class="largeInput"/></div> 
          <div style="width:30%;float:left">Pa&iacute;s: <input name="pais" id="pais" type="text" value="{$post.pais}" size="30" class="largeInput"/></div> 

          <div style="width:30%;float:left">RFC y Homoclave: <input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="30" class="largeInput"/></div> 

          <div style="clear:both"></div>
          <br />

         	<div style="clear:both"></div>
          <br />
          
          <div style="width:100%;float:left">R&eacute;gimen Fiscal: <input name="regimenFiscal" id="regimenFiscal" type="text" value="{$post.regimenFiscal}" size="124" class="largeInput"/></div> 

          <div style="clear:both"></div>
          <br />


          <div style="width:40%;float:left">Correo Electr&oacute;nico: <input name="email" id="email" type="text" value="{$post.email}" size="40" class="largeInput"/></div> 
          <div style="width:30%;float:left">Password: <input name="password" id="password" type="password" size="30" class="largeInput"/></div> 

          <div style="width:30%;float:left">Tel&eacute;fono: <input name="telefono" id="telefono" type="text" value="{$post.telefono}" size="30" class="largeInput"/></div> 

          <div style="clear:both"></div>
          <br />

      </div>

 
      <div class="formLine" style="width:100%; text-align:left">
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:50%;float:left">Producto Contratado:</div>
         <div style="width:50%;float:left">	
         	<select name="productId" id="productId"  class="largeInput">
          <option value="pro">Profesional (C&oacute;digo De Barras) ($400 Anuales) (50 Folios)</option>
          <option value="auto">PyME (C&oacute;digo De Barras) ($1,500 Anuales) (Folios Ilimitados)</option>
          <option value="v3">Empresarial (CDFi por medio de un PAC) ($2,500 anuales)</option>
          <option value="construc">Corporativo (CFDi por medio de un PAC) ($3,000 anuales)</option>
          </select></div>
          <div style="clear:both"></div>
 					<br />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:50%;float:left">Folios Adquiridos: (Solo es necesario para CFDi)</div>
         <div style="width:50%;float:left">	
         	<select name="folios" id="folios"  class="largeInput">
          <option value="50">50 Folios ($250.00)</option>
          <option value="100">100 Folios ($450.00)</option>
          <option value="150">150 Folios ($700.00)</option>
          <option value="300">300 Folios ($1050.00)</option>
          <option value="500">500 Folios ($1500.00)</option>
          <option value="1000">1000 Folios ($2500.00)</option>
          <option value="1500">1500 Folios ($3150.00)</option>
          </select></div>
          <div style="clear:both"></div>
 					<br />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:50%;float:left">Socio: (Si no sabes, marca "Ninguno")</div>
         <div style="width:50%;float:left">	
         	<select name="socioId" id="socioId"  class="largeInput">
         	{foreach from=$socios item=socio}
          <option value="{$socio.socioId}">{$socio.nombre}</option> <br />
          {/foreach}
          </select></div>
          <div style="clear:both"></div>
 					<br />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:50%;float:left">E-Mail del Proveedor: (Si no sabes, deja en blanco)</div>
         <div style="width:50%;float:left"><input name="proveedorId" id="proveedorId" type="text" value="{$post.proveedorId}" size="50"  class="largeInput"/>
         <div style="position:relative">
         		<div style="display:none;position:absolute;top:-20; z-index:100" id="suggestionDiv">
        	 	</div>
         </div>

         </div>
          <div style="clear:both"></div>
 					<br />
       
      </div>

      <div style="clear:both"></div>
			</div>

      <div class="formLine" style="width:100%; text-align:left">
        Producto Profesional: Comprobantes mediante C&oacute;digo de Barras Bidimensional. Validos si facturas menos de 4 Millones de Pesos<br />
        Producto PyME: Comprobantes mediante C&oacute;digo de Barras Bidimensional. Validos si facturas menos de 4 Millones de Pesos<br />
        Producto Empresarial: Comprobantes Fiscales Digitales (Factura Electr&oacute;nica). Recomendado a Empresas que quieran estar al d&iacute;a con esta nueva tecnolog&iacute;a <br />

        Producto Corporativo: Comprobantes Fiscales Digitales (Factura Electr&oacute;nica). Este producto presenta mas opciones (Impuestos especiales, vistos buenos, etc.) <br />
       
      </div>
     	<div class="formLine" style="text-align:center">
      	<input type="button" id="register" name="register" class="buttonForm" value="Registrarte!" class="largeInput" />
     	</div>
         
  	</fieldset>
	</form>
</div>
<div style="clear:both"></div>