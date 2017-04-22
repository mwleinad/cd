<div id="vidfondo" style="background-color:#CEC58E">
    {foreach from=$videos item=video}
        <div style="width:502px; float:left; padding-bottom:15px">
            <h3>{$video.nombrevid}</h3>
            <a
            	href="{$video.fuentevid}"
                style="display:block;width:480px;height:340px"
            	class="vidTutores">
             </a>
        </div>
    {foreachelse}
        <h3>Aun no se encuentran disponibles los v&iacute;deos</h3>
    {/foreach}
    <script languaje="javascript">flowplayer( "a.vidTutores",
											  "{$WEB_ROOT}/swf/flowplayer-3.2.4.swf",
											  { clip: { autoPlay: false,
											   			autoBuffering: true}
											  }
											 )
    </script>
	<div style="float:none"></div>
</div>