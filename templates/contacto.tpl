<!-- Body Panel start -->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyB8toip8nmgLgdGdb3pCoHNDCArgNuV6D4" type="text/javascript"></script>

<div id="bodybg">
	<div class="bodycontent">
		<!-- Bodybox start -->
		<div class="address" style="background:url('{$WEB_ROOT}/images/v3/contacto.png'); width:263px; height:469px">
    	
      <div style="padding-top:5px; padding-left:5px">
			<h3 class="title">Centro de Desarrollo</h3>
			<p style="color:#fff; font-weight:bold"><strong>{$SITENAME}:</strong><br/>
                9a sur pte #1102<br />
                Tuxtla Gutierrez, Chis, 29000<br />
                Mexico<br />
            <br />
            <strong>Telefono:</strong> 961 25 44 731<br />
            <strong>Email:</strong> ventas@{$SITENAME|lower}.com.mx<br /><br />
       </p>
       </div>
			
      <div style="padding-top:0px; padding-left:5px">
				<h3 class="title">Sucursales</h3>
      	<div id="side_bar" style="color:#FFFFFF; font-weight:bold"></div>
      </div>
		</div>
		<div class="map">
            <h3 class="title">Direcci&oacute;n</h3>
	          <div id="map" style="width: 650px; height: 400px"></div>
		</div>
		<!-- Bodybox end -->
		<br class="spacer" />
	</div>
</div>
<!-- Body Panel end -->
   <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {
      
      var side_bar_html = "";
    
      var gmarkers = [];

      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });

        gmarkers.push(marker);

        side_bar_html += '<a style="color:#fff" href="javascript:myclick(' + (gmarkers.length-1) + ')">' + name + '<\/a><br>';
         return marker;
      }

      function myclick(i) {
        GEvent.trigger(gmarkers[i], "click");
      }

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(23.03529,-100.163574), 5);

      var point = new GLatLng(16.748373,-93.124430);
      var marker = createMarker(point,"&raquo; Matriz","Comprobantes Fiscales Digitales<br>www.{$SITENAME|lower}.com<br>01 961 25 44 731")
      map.addOverlay(marker);

                       
      document.getElementById("side_bar").innerHTML = side_bar_html;
      
    }

    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    //]]>
    </script>