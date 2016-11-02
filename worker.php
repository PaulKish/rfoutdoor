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
		<img class='img-responsive' src='$image_url' height='600px'/>
	</div>";

}elseif($type == 'map'){
	//echo "<p><strong>Tweet Info </strong> </p><hr />";
	$gmap_api_key = 'AIzaSyCPA3IbbIblDCKLZ4obKt6wP4eaO3Qguzs';
	//echo "<hr> $type -- $tweetid <hr>";
	$sql = " select * from raw_logs where raw_id = '$raw_id'";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($raw_log=mysqli_fetch_assoc($res)){
		extract($raw_log);
		echo "
			<p class='tweet_text1t6'><strong>$user_id</strong> <font style='font-size: 13px;color: #8899a6;'></font>
			</p>
			Captured at: $date_time | Submitted at: $entry_time
			<hr>
			
		";
		//$lattitude = "-0.6487789000";
		//$longitude = "37.2247718000";
		echo "
		<div class='map_view' >
			<iframe id='map' src='https://www.google.com/maps/embed/v1/place?q=$lattitude+$longitude&zoom=12&key=$gmap_api_key' style='height:400px;width:100%;'>
		</iframe>
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
	$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	echo "<div class='reject_tweet' > <h3> Reject Submission </h3><hr />";
	echo "<div class='row' ><div class='col-md-12' >
			<div class='col-md-4'><img src='$image_url' height='300px' /></div>
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
	$bb_companies = get_bb_companies();
	$ad_companies = get_ad_companies();
	$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	echo "<div class='reject_tweet' > <h4> Approve Submission </h4><hr />";
	echo "<div class='row' >
		<div class='col-md-12' > <strong>Submitted by:</strong> $user_id <strong>| Comment:</strong> $comment <hr></div>
		<div class='col-md-4'><img src='$image_url' height='300px' /></div>
		<div class='col-md-8' id='approve_form_data'>
			 <form class='form-horizontal' data-target='#approve_form_data' data-async id='approve_form' method='POST' action='action.php'>
				<input type='hidden' name='raw_id' value='$raw_id' />
				<input type='hidden' name='lattitude' value='$lattitude' />
				<input type='hidden' name='longitude' value='$longitude' />
				<input type='hidden' name='photo' value='$photo' />
				<input type='hidden' name='capture_time' value='$date_time' />
				<input type='hidden' name='type' value='action_approve' />
				  <fieldset disabled>
				  <div class='form-group'>
					<label class='control-label col-sm-2' for='agent'>Submitted BB Company:</label>
					<div class='col-sm-10'>
					  <input type='text' class='form-control' id='bb_co_sub' placeholder='$bb_co_name' value='$bb_co_name'>
					</div>
				  </div>
				 </fieldset>
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

