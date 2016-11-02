<? // echo "Data: $data "; exit; ?>
<div id="map" class='col-md-12' style="height: 500px;"></div>
<!-- <div id="marker_details" class='col-md-4' style='height: 200px;'></div>  -->
<script>
	// Define your locations: HTML content for the info window, latitude, longitude
	var locations = [ <? echo $data; ?>];

	// Setup the different icons and shadows
	var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';

	var icons = [
	  iconURLPrefix + 'red-dot.png',
	  iconURLPrefix + 'green-dot.png',
	  iconURLPrefix + 'blue-dot.png',
	  iconURLPrefix + 'orange-dot.png',
	  iconURLPrefix + 'purple-dot.png',
	  iconURLPrefix + 'pink-dot.png',      
	  iconURLPrefix + 'yellow-dot.png'
	]
	var iconsLength = icons.length;

	var map = new google.maps.Map(document.getElementById('map'), {
	  zoom: 15,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  mapTypeControl: false,
	  streetViewControl: false,
	  panControl: false,
	  zoomControlOptions: {
		 position: google.maps.ControlPosition.LEFT_BOTTOM
	  }
	});

	var infowindow = new google.maps.InfoWindow({
	  maxWidth: 400
	});
	var markers = new Array();
	var iconCounter = 0;

	// Add the markers and infowindows to the map
	for (var i = 0; i < locations.length; i++) {  
		var marker = new google.maps.Marker({
		position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		map: map,
		draggable:true,
		icon: icons[iconCounter]
	  });

	  markers.push(marker);

	  google.maps.event.addListener(marker, 'click', (function(marker, i) {
	  	return function() {
		var jcontent = locations[i][0] + locations[i][4];
		//var raw_id = "'"+ locations[i][3] + "'";
		//var agent_id = "'"+ locations[i][4] + "'";
		//joe_test(raw_id,agent_id);
		//alert(locations[i][3]);
		infowindow.setContent(jcontent );
		  infowindow.open(map, marker);
		}
	  
	  })(marker, i));
	  <?php if(isset($drag_end)){ echo $drag_end ;} ?>
	  
	  iconCounter++;
	  // We only have a limited number of possible icon colors, so we may have to restart the counter
	  if(iconCounter >= iconsLength) {
		iconCounter = 0;
	  }
	}

	function autoCenter() {
	  //  Create a new viewpoint bound
	  var bounds = new google.maps.LatLngBounds();
	  //  Go through each...
	  for (var i = 0; i < markers.length; i++) {  
				bounds.extend(markers[i].position);
	  }
	  //  Fit these bounds to the map
	  map.fitBounds(bounds);
	}
	autoCenter();
</script> 

