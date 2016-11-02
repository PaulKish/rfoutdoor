<?php
require_once 'functions.php';
db_con('rf_outdoor');
extract($_POST);

if($type=='image'){
	$sql = "select * from raw_logs where raw_id = '$raw_id'";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($raw_log = mysqli_fetch_assoc($res)){
		extract($raw_log);
		$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	}else{
		echo "<p> No Photo found for submitted entry!!!!  </p>";
	}
	echo "<div class='image_view' >
			<img style='height:400px;display: block;margin:0 auto;' src='$image_url' />
		</div>";
}elseif($type == 'save_geo'){
	//print_r($_POST);
	$sql = "update raw_logs set lattitude = '$lattitude', longitude = '$longitude' where raw_id = '$raw_id'";
	//echo "<hr>$sql<hr> "; exit;
	if(mysqli_query($GLOBALS["___mysqli_ston"], $sql)){
		echo " <hr> New coordinates successfully saved!!! <hr>";
	}else{
			echo "<hr>Unable to save new coodinates!!! Kindly try again.<hr>";
	}

}elseif($type == 'drag-marker'){
	$sql = "select * from raw_logs where raw_id = '$raw_id'";
	
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($raw_log = mysqli_fetch_assoc($res)){
		extract($raw_log);
		$agent_name = get_agent_name($raw_id);
		echo "
			<p class='tweet_text1t6'><strong>Agent:</strong> $agent_name <font style='font-size: 13px;color: #8899a6;'></font>
			</p>
			<strong>Captured at:</strong> $date_time | <strong>Submitted at:</strong> $entry_time <br>";
	
		$bb_co_name = get_bb_co_name($bb_co_id);
		$agent_name = get_agent_name($raw_id);
		$agent_name = javascript_escape($agent_name);
		$bb_co_name = javascript_escape($bb_co_name);
		$lattitude = javascript_escape($lattitude);
		$longitude = javascript_escape($longitude);
		$agent_id = javascript_escape($agent_id);
		$raw_id = javascript_escape($raw_id);
		$date_time = javascript_escape($date_time);
		
		$data = "['<h5>$agent_name | $date_time <br> $bb_co_name </h5>','$lattitude' , '$longitude', '$raw_id']";	
		
		$drag_end = "
		google.maps.event.addListener(marker, 'dragend', (function(marker, i) {
			return function() {
				var new_lat = this.getPosition().lat();
				var new_lng = this.getPosition().lng();
				var div = '<hr><div id=\'geo_save\' style=\'float:right\'><button class=\'btn btn-sm btn-primary\' onclick=\'save_new_geo(\"$raw_id\",\"' + new_lat + '\",\"' + new_lng + '\");\'>Save</button></div> ';
				//var coods = 'Old Coods:' + locations[i][1] + ' | ' + locations[i][2] + '<br> New Coods: ' + new_lat + ' | ' + new_lng + div ;
				var cont = '<br><strong>Agent:</strong> $agent_name <br><br><strong>Hold and Drag Marker to shift Geo Location Coodinates ... </strong>';
				coods =  new_lat + ' | ' + new_lng + cont + div ;
				infowindow.setContent(coods);
				infowindow.open(map, marker);
			}
		  })(marker, i));";
		 
		 require_once 'maps.php';
	}else{
		echo "No results found for this entry";
	}
	
}elseif($type == 'map'){

	//echo "<p><strong>Tweet Info </strong> </p><hr />";
	$gmap_api_key = 'AIzaSyCPA3IbbIblDCKLZ4obKt6wP4eaO3Qguzs';
	//echo "<hr> $type -- $tweetid <hr>";
	$sql = " select * from raw_logs where raw_id = '$raw_id'";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($raw_log=mysqli_fetch_assoc($res)){
		extract($raw_log);
		$agent_name = get_agent_name($raw_id);
		echo "
			<p class='tweet_text1t6'><strong>Agent:</strong> $agent_name <font style='font-size: 13px;color: #8899a6;'></font>
			</p>
			<strong>Captured at:</strong> $date_time | <strong>Submitted at:</strong> $entry_time
			";
		echo "<div style='float:right'><button class='btn btn-sm btn-primary' onclick='log_entry_actions(\"$raw_id\", \"drag-marker\");'>
		Change GeoLocation</button></div> <hr>";
		
		$bb_co_name = get_bb_co_name($bb_co_id);
		$agent_name = javascript_escape($agent_name);
		$date_time = javascript_escape($date_time);
		$bb_co_name = javascript_escape($bb_co_name);
		$agent_id = javascript_escape($agent_id);
		/*
		$data = "['<h5>$agent_name | $date_time <br /> $bb_co_name </h5>',$lattitude , $longitude, '$raw_id','$agent_id', '<hr>']";
		require "maps.php";
		*/
		 echo "
		<div class='map_view' >
			<iframe id='map' src='https://www.google.com/maps/embed/v1/place?q=$lattitude+$longitude&zoom=15&key=$gmap_api_key' style='height:350px;width:100%;'></iframe>
		</div> "; 
		
	}else { 
		echo "No Results Found !!!!!"; 
	}
}elseif($type =='reject'){
	$sql = "select * from raw_logs where raw_id = '$raw_id'";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		if($raw_log=mysqli_fetch_assoc($res)){
			extract($raw_log);
		}
		$agent_name = get_agent_name($raw_id);
	$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	echo "<div class='reject_tweet' > <h4> Reject Submission </h4><hr />
		<div class='col-md-12' > <strong>Agent:</strong> $agent_name <br /> <strong>Comment:</strong> $comment | 
			<strong>Captured at:</strong> $date_time | <strong>Submitted at:</strong> $entry_time
		<hr></div>
	";
	echo "<div class='row' ><div class='col-md-12' >
			<div class='col-md-4'><img class='img-responsive' src='$image_url' height='300px' /></div>
			<div class='col-md-8' id='reject_div'>
				<form data-target='#reject_div' data-async id='reject_form' method='POST' action='action.php' >
					<input type='hidden' name='raw_id' value='$raw_id' id='raw_id' />
					<input type='hidden' name='type' value='action_reject' id='action' />
					<div class='form-group' id='reject_form_content'>
						<textarea name='comment' class='form-control' rows='5' id='comment' placeholder='Reason for Rejection...'></textarea>
					</div>
					<button type='submit' class='btn btn-default btn-primary' style='float:right' id='submit_rej'>Submit</button>
				</form>
			</div>
			</div>
		</div>";
}elseif($type =='approve'){
	$sql = "select * from raw_logs where raw_id = '$raw_id'";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		if($raw_log=mysqli_fetch_assoc($res)){
			extract($raw_log);
		}
	$agent_name = get_agent_name($raw_id);
	$bb_companies = get_bb_companies($bb_co_id);
	$ad_companies = get_ad_companies();
	$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	
	echo "<div class='reject_tweet' > <h4> Approve Submission </h4><hr />";
	echo "<div class='row' >
		<div class='col-md-12' > <strong>Agent:</strong> $agent_name  <strong>Comment:</strong> $comment <br />
		<strong>Captured at:</strong> $date_time | <strong>Submitted at:</strong> $entry_time
		<hr></div>
		<div class='col-md-4'><img class='img-responsive' src='$image_url' height='300px' /></div>
		<div class='col-md-8' id='approve_form_data'>
			 <form class='form-horizontal' data-target='#approve_form_data' data-async id='approve_form' method='POST' action='action.php'>
				<input type='hidden' name='raw_id' value='$raw_id' />
				<input type='hidden' name='lattitude' value='$lattitude' />
				<input type='hidden' name='longitude' value='$longitude' />
				<input type='hidden' name='photo' value='$photo' />
				<input type='hidden' name='capture_time' value='$date_time' />
				<input type='hidden' name='type' value='action_approve' />
				  
				  <div class='form-group'>
					  <label for='bb_co_id' class='control-label col-sm-2'>Select BB Company:</label>
					  <div class='col-sm-10'>
						$bb_companies
					  </div>
					</div>
					<div class='form-group'>
					  <label for='bb_co_id' class='control-label col-sm-2'>Select Company:</label>
					  <div class='col-sm-10'>
					  <select name='co_id' class='form-control' id='bb_cos' onChange='getBrands(this.value, \"brands\");'>
							<option value='0' >Select Company</option>
							$ad_companies
						</select>
					  </div>
					</div>
					<div class='form-group'>
					  <label for='bb_co_id' class='control-label col-sm-2'>Select Company Brand:</label>
					  <div class='col-sm-10' id='co_brands'>
						
					  </div>
					</div>
					<div class='form-group'>
						<label class='control-label col-sm-2' for='agent'>Banner Size:</label>
						<div class='col-sm-10'>
							<input type='text' class='form-control' name='banner_size' placeholder='Type Banner size...' >
						</div>
					</div>
				  <div class='form-group'>
						<label class='control-label col-sm-2' for='agent'>Banner Rate:</label>
						<div class='col-sm-10'>
							<input type='text' class='form-control' name='banner_rate' placeholder='Type Banner Rate...' >
						</div>
				  </div>
				  <div class='form-group'>
					<div class='col-sm-offset-2 col-sm-10'>
					  <button type='submit' class='btn btn-default btn-primary' style='float:right' >Submit</button>
					</div>
				  </div>
			</form>
		</div>
	</div></div>";

}elseif($type == 'brands'){
	echo $brands_drop = get_co_brands($co_id);
}elseif($type =='pie_drilldown'){
	db_con();
	$num = 1;
	$date_s = date_format(date_create($start_date), 'jS M Y');
	$date_e = date_format(date_create($start_date), 'jS M Y');
	echo "<center><h4>$county_name County </h4> <hr></center>";
	echo "<div id='pie_drilldown' style='height:70%;overflow-y:auto;'> ";
	echo "<img src='images/loading.gif' id='loading-indicator' style='display:none' />";
	//echo get_tweets_titles(); 
	echo "
	<table id='list_table' class='table table-striped table-hover table-condensed'  >
		<thead>
			<th class='td_title'>#</th>
			<th class='td_title'>Date</th>
			<th class='td_title'>Time</th>
			<th class='td_title'>Base</th>
			<th class='td_title'>Road</th>
			<th class='td_title'>Place</th>
			<th class='td_title'>View</th>
		</thead>";
	$qry = "select * from accidents_data where county = '$county_name' and date between '$start_date' and '$end_date' order by date desc, time asc";
	//echo "<hr> $qry_count <hr>";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	//Table listing
	while($row = mysqli_fetch_array($results))
	{ 
		extract($row);
		$time_f = date('H:i', strtotime($time));
		$date_f = date_format(date_create($date), 'jS M Y');
		$county = ucfirst(strtolower($county));
		$road = ucfirst(strtolower($road));
		$base_sub_base = ucfirst(strtolower($base_sub_base));
		$place = ucfirst(strtolower($place));
		//$involved = ucfirst(strtolower($involved));
		$description = ucfirst(strtolower($description));
		//start listing
		echo "
		<tbody>
		<tr>
			<td><label id='$auto_id' > $num </label></td> 
			<td style='min-width:100px;'>$date_f</td> 
			<td>$time_f</td> 	
			<td>$base_sub_base</td>
			<td>$road</td> 	
			<td>$place</td> 	
		 	
			<td  style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:300px;'>
				<a href='#' id='nosub' class='nosub' onclick='PopStuff(\"$auto_id\", \"view\");'>View</a></td> 
			";
			echo "</tr>";
		
		//end listing
		$num ++; 
	} 
	echo "</tbody> </table> </div>";
}
?>

