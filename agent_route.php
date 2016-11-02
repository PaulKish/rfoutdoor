<div style="display: block;" class="table-responsive row col-md-12" id="map_content">
<?php
extract($_POST);
if(empty($_POST['sd']) || empty($_POST['ed'])){
	echo "Please select valid Start Date and End Date !!!";
	exit;
}
$start_d = date_format(date_create($sd), 'jS, M Y');
$end_d = date_format(date_create($ed), 'jS, M Y');
echo "<h4>Agent Route Submissions between $start_d and $end_d  </h4><hr>";
require_once('functions.php');

if(isset($sd) || isset($ed)){
	$date_qry = "   date(entry_time) between '$sd' and '$ed' and lattitude is not NULL and longitude is not NULL order by entry_time desc ";
}else{
	$date_qry = " lattitude is not NULL and longitude is not NULL order by entry_time desc $limit";
}
if($agent_id == '0' || $agent_id == ''){
	$agent_qry = ' ';
}else{
	$agent_qry = " agent_id = $agent_id and ";
}

db_con('rf_outdoor');
$qry = "select * from raw_logs where $agent_qry $date_qry  ";
//echo $qry; exit;
$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$data = '';
$data_r = '';
while($row = mysqli_fetch_array($results))
{ 
	extract($row);
	
	$agent_name = get_agent_name($raw_id);
	$bb_co_name = get_bb_co_name($bb_co_id);
	$agent_name = javascript_escape($agent_name);
	$date_time = javascript_escape($date_time);
	$bb_co_name = javascript_escape($bb_co_name);
	$agent_id = javascript_escape($agent_id);
	
	$data .= "['<h5>$agent_name | $date_time <br /> $bb_co_name </h5>',$lattitude , $longitude, '$raw_id','$agent_id', '<hr>']";	
	$data_r .= "['$bb_co_name | $date_time ', '$lattitude' , '$longitude', '$raw_id', '$agent_name'] <hr>";	
	$data .=',';
	
}
//echo $data_r;
//echo preg_replace('/[^A-Za-z0-9\-]/', '', $data_r);
//print_r($row);

?>

<!-- <div id="map" class='col-sm-12' style="height: 600px;"></div>  -->

<div id="map" class='col-md-8' style="height: 600px;"></div>
<div id="marker_details" class='col-md-4' style='height: 200px;'></div> 
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
	  //center: new google.maps.LatLng(-37.92, 151.25),
	  //-1.2833358,36.7965399
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  mapTypeControl: false,
	  streetViewControl: false,
	  panControl: false,
	  zoomControlOptions: {
		 position: google.maps.ControlPosition.LEFT_BOTTOM
	  }
	});

	var infowindow = new google.maps.InfoWindow({
	  maxWidth: 300
	});

	var markers = new Array();

	var iconCounter = 0;

	// Add the markers and infowindows to the map
	for (var i = 0; i < locations.length; i++) {  
			
		var marker = new google.maps.Marker({
		position: new google.maps.LatLng(locations[i][1], locations[i][2]),
		map: map,
		icon: icons[iconCounter]
	  });

	  markers.push(marker);

	  google.maps.event.addListener(marker, 'click', (function(marker, i) {
	  	return function() {
		var jcontent = locations[i][0] + locations[i][4];
		var raw_id = "'"+ locations[i][3] + "'";
		var agent_id = "'"+ locations[i][4] + "'";
		joe_test(raw_id,agent_id);
		//alert(locations[i][3]);
		infowindow.setContent(jcontent );
		  infowindow.open(map, marker);
		}
	  
	  })(marker, i));
	  
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




</div>
