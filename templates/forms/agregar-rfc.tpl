<div id="divForm">
	<form id="agregarRfcForm" name="agregarRfcForm" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Nombre Completo o Razón Social:</div><input name="razonSocial" id="razonSocial" type="text" value="{$post.razonSocial}" size="50"/>
        <hr />
       
      </div>
       <div class="formLine">
       		Dirección:<br />
          <div style="width:30%;float:left">Calle:</div> <input name="calle" id="calle" type="text" value="{$post.calle}" size="50"/><br />
          <div style="width:30%;float:left">No. Exterior:</div> <input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="10"/><br />
          <div style="width:30%;float:left">No. Interior:</div> <input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="10"/><br />
          <div style="width:30%;float:left">Referencia:</div> <input name="referencia" id="referencia" type="text" value="{$post.referencia}" size="50"/><br />
          <div style="width:30%;float:left">Colonia:</div> <input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="30"/><br />
          <div style="width:30%;float:left">Localidad:</div> <input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="30"/><br />
          <div style="width:30%;float:left">Municipio o Delegación:</div> <input name="municipio" id="municipio" type="text" value="{$post.ciudad}" size="30"/><br />
          <div style="width:30%;float:left">Ciudad:</div> <input name="ciudad" id="ciudad" type="text" value="{$post.ciudad}" size="30"/><br />
          <div style="width:30%;float:left">CP:</div> <input name="cp" id="cp" type="text" value="{$post.cp}" size="10"/><br />
          <div style="width:30%;float:left">Estado:</div> <input name="estado" id="estado" type="text" value="{$post.estado}" size="30"/><br />
          <div style="width:30%;float:left">País:</div> <input name="pais" id="pais" type="text" value="{$post.pais}" size="50"/><br />
 					<hr />
      </div>

       <div class="formLine">
          <div style="width:15%;float:left">RFC y Homoclave:</div> 
          <div style="width:15%;float:left"><input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="13"/></div>
          <div style="clear:both"></div>
 					<hr />
      </div>

      <div style="clear:both"></div>
			<hr />
     	<div class="formLine" style="text-align:center">
      	<input type="button" id="agregarRfc" name="agregarRfc" class="buttonForm" value="Agregar RFC" />
     	</div>
        
  	</fieldset>
	</form>
</div>
