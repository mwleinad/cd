

<div id="divForm">
	<form id="editConfigForm" name="editConfigForm" method="post" action="">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Email:</div><input name="email" id="email" type="text" value="{$post.email}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Home:</div><textarea name="home" id="home" type="text"  size="50" cols="50">{$post.home}</textarea>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Nosotros:</div><textarea name="nosotros" id="nosotros" type="text" size="50" cols="50">{$post.nosotros}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Mision:</div><textarea name="mision" id="mision" type="text" size="50" cols="50">{$post.mision}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Vision:</div><textarea name="vision" id="vision" type="text" size="50" cols="50">{$post.vision}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Valores:</div><textarea name="valores" id="valores" type="text" size="50" cols="50">{$post.valores}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Labor Soclal:</div><textarea name="laborSocial" id="laborSocial" type="text" size="50" cols="50">{$post.laborSocial}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Eventos:</div><textarea name="eventos" id="eventos" type="text" size="50" cols="50">{$post.eventos}</textarea>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Formatos:</div><textarea name="formatos" id="formatos" type="text" size="50" cols="50">{$post.formatos}</textarea>
			</div>
      
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Producto:</div><textarea name="producto" id="producto" type="text"  size="50" cols="50">{$post.producto}</textarea>
			</div>
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Competencia:</div><textarea name="competencia" id="competencia" type="text"  size="50" cols="50">{$post.competencia}</textarea>
			</div>
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Beneficios Empresariales:</div><textarea name="beneficios" id="beneficios" type="text"  size="50" cols="50">{$post.beneficios}</textarea>
			</div>
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Como funciona:</div><textarea name="funciona" id="funciona" type="text"  size="50" cols="50">{$post.funciona}</textarea>
			</div>
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Preguntas frecuentes:</div><textarea name="preguntas" id="preguntas" type="text"  size="50" cols="50">{$post.preguntas}</textarea>
			</div>
            
			<div style="clear:both"></div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Im&aacute;genes carrusel:</div><input name="carrusel" id="carrusel" type="text"  size="50" cols="50" value="{$post.carrusel}">
			</div>
            
            
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="submit" id="editConfig" name="editConfig" class="buttonForm" value="Editar Config" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditConfig"/>
			<input type="hidden" id="idConfig" name="idConfig" value="{$post.idConfig}" width="500" height="300"/>
		</fieldset>
	</form>
</div>
