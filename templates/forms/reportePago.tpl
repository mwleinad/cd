<br />
<br />
{if $cmpMsg}
<div align="center" style="color:#009900">{$cmpMsg}<br /><br /></div>
{/if}
{if $errMsg}
<div align="center" style="color:#FF0000">{$errMsg}<br /><br /></div>
{/if}
<div id="divForm">
	<form id="frmCertificado" name="frmCertificado" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="accion" value="guardar_certificado" />
    <input type="hidden" name="rfc" value="{$info.rfc}" />
    <input type="hidden" name="razonSocial" value="{$info.razonSocial}" />
    <input type="hidden" name="interno" value="{$info.interno}" />
    <fieldset>				
             
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Metodo de Pago:</div> 
        <div style="width:750px;float:left">
        <select name="metodoPago" id="metodoPago" onchange="showHideData()"  class="largeInput">
        	<option value="">Elige...</option>
          {if $info.interno == "No"}
        	<option value="Deposito Bancario (en Efectivo)">Deposito Bancario (en Efectivo)</option>
        	<option value="Transferencia Bancaria (Mismo Banco)">Transferencia Bancaria (Mismo Banco)</option>
        	<option value="Transferencia Interbancaria (Diferente Banco)">Transferencia Interbancaria (Diferente Banco)</option>
        	<option value="Deposito en Cheque (Mismo Banco)">Deposito en Cheque (Mismo Banco)</option>
        	<option value="Deposito en Cheque (Diferente Banco)">Deposito en Cheque (Diferente Banco)</option>
          {/if}
          {if $info.rfc && $info.interno == "Si"}
       			<option value="Cliente Interno">Cliente Interno</option>
          {/if}
          {if !$info.rfc}
        	<option value="Paypal">Paypal</option>
          {/if}
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>

          {if $info.interno == "No" && !$info.rfc}
      <div class="formLine" style="width:100%; text-align:left" id="showIfBanco">
        <div style="width:150px;float:left">*Banco:</div> 
        <div style="width:750px;float:left">
        <select name="banco" id="banco" onchange=""  class="largeInput">
        	<option value="Bancomer 2838155968">Bancomer 2838155968</option>
        	<option value="OXXO 4152313047597633">OXXO 4152313047597633</option>
        	<option value="Paypal">Paypal</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
          {/if}

          {if $info.rfc && $info.interno == "No"}
      <div class="formLine" style="width:100%; text-align:left" id="showIfBanco">
        <div style="width:150px;float:left">*Banco:</div> 
        <div style="width:750px;float:left">
        <select name="banco" id="banco" onchange=""  class="largeInput">
        	<option value="Banamex 8158768">Banamex 8158768</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
          {/if}


      
          {if $info.interno != "Si"}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Fecha del Deposito:</div> 
        <div style="width:750px;float:left"><input name="fecha" id="fecha" type="date" size="30" value="{$post.fecha}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      {/if}
      
          {if $info.rfc && $info.interno == "Si"}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Monto y Concepto del Deposito:</div> 
        <div style="width:750px;float:left">
        <select name="monto" id="monto"  class="largeInput">
        	<option value="50-58">50 Timbres $58.00</option>
        	<option value="100-116">100 Timbres $116.00</option>
        	<option value="150-174">150 Timbres $174.00</option>
        	<option value="200-232">200 Timbres $232.00</option>
        	<option value="500-580">500 Timbres $580.00</option>
        	<option value="1000-1160">1000 Timbres $1,160.00</option>
        	<option value="2000-2320">2000 Timbres $2,230.00</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      	{/if}
      
          {if $info.rfc  && $info.interno == "No"}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Monto y Concepto del Deposito:</div> 
        <div style="width:750px;float:left">
        <select name="monto" id="monto"  class="largeInput">
        	<option value="100-580">100 Timbres $580.00</option>
        	<option value="150-783">150 Timbres $783.00</option>
        	<option value="200-928">200 Timbres $928.00</option>
        	<option value="500-1740">500 Timbres $1,740.00</option>
        	<option value="1000-2900">1000 Timbres $2,900.00</option>
        	<option value="2000-4640">2000 Timbres $4,640.00</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      	{/if}

          {if !$info.rfc}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Monto y Concepto del Deposito:</div> 
        <div style="width:750px;float:left">
        <select name="monto" id="monto"  class="largeInput">
        	<option value="50-400">50 Timbres $400.00</option>
        	<option value="100-700">100 Timbres $700.00</option>
        	<option value="150-900">150 Timbres $900.00</option>
        	<option value="200-1200">200 Timbres $1,200.00</option>
        	<option value="300-1300">300 Timbres $1,300.00</option>
        	<option value="500-1300">500 Timbres $1,500.00</option>
        	<option value="1000-2500">1000 Timbres $2,500.00</option>
        	<option value="1000-3000">1500 Timbres $3,000.00</option>
        	<option value="2000-3600">2000 Timbres $3,600.00</option>
        	<option value="impuesto-1600">Modulo de Impuestos 1 a&Ntilde;o $1,600.00</option>
        	<option value="nomina-1000">Modulo de Nomina 1 a&Ntilde;o $1,000.00</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      	{/if}

          {if $info.interno != "Si"}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*# autorizacion o Referencia:</div> 
        <div style="width:750px;float:left"><input name="autorizacion" id="autorizacion" type="text" size="30" value="" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      {/if}
      
      {if $info.interno != "Si"}
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Comprobante de pago:</div> 
        <div style="width:750px;float:left"><input name="comprobante" id="comprobante" type="file" size="30" value="" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      {/if}
      
          {if $info.interno == "No" && !$info.rfc}
      <div class="formLine" style="width:100%; text-align:left" id="showIfBanco">
        <div style="width:150px;float:left">Requiere Factura?</div> 
        <div style="width:750px;float:left">
        <select name="factura" id="factura" onchange=""  class="largeInput">
        	<option value="No">No</option>
        	<option value="Si">Si</option>
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
          {/if}

      

       	<div style="clear:both; padding-top:5px"></div>
      </div>
      
 		<hr />

      <div align="left">* Campos requeridos.</div>
	    <div class="formLine" style="text-align:center">
      <input type="submit" id="enviar" name="enviar" value="Reportar Pago" />
  	</fieldset>
    </form>

      </div>
</div>
