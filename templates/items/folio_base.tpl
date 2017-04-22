<tr>
    <td align="center">{$folio.serie}</td>
    <td align="center">{$folio.folioInicial}</td>
    <td align="center">{$folio.consecutivo}</td>
    <td align="center">{if $folio.logo}<img src="{$folio.logo}" width="50" height="50" />{/if}</td>                
    {if $info.version == "auto"}
        <td align="center">{if $folio.qr}<img src="{$folio.qr}" width="50" height="50" />{/if}</td>
    {/if}
    <td align="center">
    {if in_array("edit", $nuevosPermisos.nuevos_folios)}
        {if $info.version == "auto"}    
        <form method="post" action="" enctype="multipart/form-data" name="qr-{$folio.serieId}">
        <input type="file" name="qr" id="qr" /><input type="hidden" name="serieId" id="serieId" value="{$folio.serieId}"/><input type="submit" value="Cambiar QR" />  
        </form>
        {/if}
        <br />
        <form method="post" action="" enctype="multipart/form-data" name="cedula-{$folio.serieId}">
        <input type="file" name="cedula" id="cedula" />
        <input type="hidden" name="serieId" id="serieId" value="{$folio.serieId}"/>
        <input type="submit" value="Cambiar Logo" />
        </form>
    {/if}
    </td>
    <td align="center">        
        {if in_array("edit", $nuevosPermisos.nuevos_folios)}
        <a href="javascript:void(0)" onclick="EditFoliosPopup({$folio.serieId})" title="Editar">        
        <img src="{$WEB_ROOT}/images/b_edit.png" border="0"/>
        </a>
        {/if}
        {if in_array("delete", $nuevosPermisos.nuevos_folios)}
        <a href="javascript:void(0)" onclick="DeleteFolio({$folio.serieId})" title="Eliminar">
        <img src="{$WEB_ROOT}/images/b_dele.png" border="0"/>
        </a>
        {/if}
    </td>
</tr>