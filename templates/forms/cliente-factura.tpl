<div id="divForm">
<form id="nuevaFactura" name="nuevaFactura" method="post">
    <input type="hidden" id="userId" name="userId" value="" />
    <fieldset>    
        <div style="margin-left:auto; margin-right:auto; display:block; width:260px; text-align:center;">
            <div>Clave del Ticket (CT):</div> 
            <div style="margin-left:auto; margin-right:auto; display:block; width:170px; text-align:center;">
                <input name="ticketTC" id="ticketTC" type="text" class="largeInput" placeholder="Clave de Facturacion"/> 
            </div>
            <div class="formLine" id ="reemplazarBoton" style="margin-left:auto; margin-right:auto; display:block; width:25%; text-align:center;">
            <a class="button" id="generarFactura" name="generarFactura"><span>Generar</span></a>
            </div>
		</div>
        <br />
        <br />
        <div class="formLine" style="margin-left:auto; margin-right:auto; display:block; width:25%; text-align:center;" class="formLine" id="totalesDesglosadosDiv"></div>
    </fieldset>
</form>
</div>
