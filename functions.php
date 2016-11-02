<?php
function db_con($db)
{
	//mysql_select_db('rf_outdoor', mysql_connect('localhost', 'root', 'root'));
	((bool)mysqli_query( ($GLOBALS["___mysqli_ston"] = mysqli_connect('localhost',  'root',  'root')), "USE " . $db));
}
function get_geo($tweet_id)
{
	db_con('tweets');
	$qry = "select * from geo_tweet where tweet_id = $tweet_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($row = mysqli_fetch_array($results)) extract($row);
	if(!isset($geo_lat) || !isset($geo_long)){
		$map_link = 'N/A';
	}else{
		$map_link = "<a href='http://maps.google.com/maps?q=$geo_lat++$geo_long' title='Click to view on map' target='_blank'> $geo_lat <br> $geo_long</a>";
	}
	return $map_link;
}
function isWeekend($date) {
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
}
function get_bb_co_name($bb_co_id){
	db_con('rf_outdoor');
	$qry = "select * from bb_companies where co_id = $bb_co_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($row = mysqli_fetch_array($results)){
		extract($row);
		return $company_name;
	}else{
		return "N/A";
	}
}
function get_co_name($brand_id){
	db_con('forgedb');
	$qry = "select company_name from user_table,brand_table where brand_table.company_id = user_table.company_id and brand_id = $brand_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($row = mysqli_fetch_array($results)){
		extract($row);
		return $company_name;
	}else{
		return "N/A";
	}
}
function get_comment($raw_id){
	db_con('rf_outdoor');
	$qry = "select comment from raw_logs where raw_id = $raw_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($row = mysqli_fetch_array($results)){
		extract($row);
		return $comment;
	}else{
		return "N/A";
	}
}
function get_agent_name($raw_id){
	db_con('rf_outdoor');
	$qry = "select firstname,lastname from agents,raw_logs where raw_logs.agent_id=agents.agent_id and raw_id = $raw_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($row = mysqli_fetch_array($results)){
		extract($row);
		$agent_name = "$firstname $lastname";
		return $agent_name;
	}else{
		return "N/A";
	}
}

function get_brand_name($brand_id){
	db_con('forgedb');
	$qry = "select * from brand_table where brand_id = $brand_id";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($row = mysqli_fetch_array($results)){
		extract($row);
		return $brand_name;
	}else{
		return "N/A";
	}
}
function GetAddress( $lat, $lng )
{   
    // Construct the Google Geocode API call
    $URL = "http://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&sensor=false";
    // Extract the location lat and lng values
    $data = file( $URL );
    foreach ($data as $line_num => $line) 
    {
        if ( false != strstr( $line, "\"formatted_address\"" ) )
        {
            $addr = substr( trim( $line ), 22, -2 );
            break;
        }
    }
    return $addr;
}
function get_agent_users(){
	db_con('rf_outdoor');
	$sel = "<select name='agent_id' class='form-control' id='agent_id'>
			<option value='0' >All Agents</option> ";
	$qry = "select * from agents order by firstname asc";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($rows = mysqli_fetch_assoc($res)){
		extract($rows);
		$agent_name = "$firstname $lastname";
		$sel .= "<option value='$agent_id' >$agent_name</option>";
	}
	$sel .= "</select>";
	return $sel;
}

function get_bb_companies($bb_co_id_sel=0){
	db_con('rf_outdoor');
	$sel = "<select name='bb_co_id' class='form-control' id='bb_cos'>
			<option value='0' >Select Billboard Company</option> ";
	$qry = "select * from bb_companies order by company_name asc";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($bb_cos = mysqli_fetch_assoc($res)){
		extract($bb_cos);
		if($co_id == $bb_co_id_sel){
			$selected = ' selected';
		}else{
			$selected = '';
		}
		$sel .= "<option value='$co_id' $selected>$company_name</option>";
	}
	$sel .= "</select>";
	return $sel;
}

function get_ad_companies(){
	db_con('forgedb');
	$sel = " ";
	$qry = "select company_id co_id,company_name from user_table where level = 6 order by company_name asc";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($bb_cos = mysqli_fetch_assoc($res)){
		extract($bb_cos);
		$sel .= "<option value='$co_id' >$company_name</option>";
	}
	//$sel .= "</select>";
	return $sel;
}
function get_co_brands($co_id){
	db_con('forgedb');
	$sel = "<select class='form-control' id='co_brands' name='brand_id' >
				<option value='0'>Select Brand </option>";
	$qry = "select brand_id,brand_name from brand_table where company_id = $co_id order by brand_name asc";
	$res = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($brands = mysqli_fetch_assoc($res)){
		extract($brands);
		$sel .= "<option value='$brand_id' >$brand_name</option>";
	}
	$sel .= "</select>";
	return $sel;
}
function get_raw_logs_titles()
{
	$titles=
	"<table id='list_table' class='table table-striped table-hover table-condensed'  >
	<thead >
	<th class='td_title'>#</th>
	<th class='td_title' >Agent</th>
	<th class='td_title'>Capture Time</th>
	<th class='td_title' >Submission Time </th>	
	<th class='td_title' >Map</th>
	<th class='td_title' >Company</th>
	<th class='td_title' >Comment</th>
	<th class='td_title' >Photo</th>
	<th class='td_title' >Status</th>
	<th class='td_title' >Action</th>
	</tr></thead>";
	 return $titles;
}
function get_processed_logs_titles()
{
	$titles=
	"<table id='list_table' class='table table-striped table-hover table-condensed'  >
	<thead >
	<th class='td_title'>#</th>
	<th class='td_title' >Agent</th>
	<th class='td_title' >Comment</th>
	<th class='td_title'>Capture Time</th>
	<th class='td_title' >Approval Time </th>	
	<th class='td_title' >Map</th>
	<th class='td_title' >BB Company</th>
	<th class='td_title' >Company</th>
	<th class='td_title' >Brand</th>
	<th class='td_title' >Photo</th>
	<th class='td_title' >Size</th>
	<th class='td_title' >Rate</th>
	</tr></thead>";
	 return $titles;
}
function get_agent_list_titles()
{
	$titles=
	"<table id='list_table' class='table table-striped table-hover table-condensed'  >
	<thead >
	<th class='td_title'>#</th>
	<th class='td_title' >Name</th>
	<th class='td_title' >Created</th>	
	<th class='td_title' >Zone</th>
	<th class='td_title' >username</th>
	<th class='td_title' >Email</th>
	<th class='td_title' >Status</th>
	<th class='td_title' >Submissions</th>
	<th class='td_title' >Action</th>
	</tr></thead>";
	 return $titles;
 
}
function get_bb_co_list_titles()
{
	$titles=
	"<table id='list_table' class='table table-striped table-hover table-condensed'  >
	<thead >
	<th class='td_title'>#</th>
	<th class='td_title' >Billboard Company</th>
	<th class='td_title' >Description</th>
	<th class='td_title' >Created</th>		
	<th class='td_title' >View Sites</th>	
	<th class='td_title' >Actions</th>			
	</tr></thead>";
	 return $titles;
 
}
function get_bb_site_list_titles()
{
	$titles=
	"<table id='list_table' class='table table-striped table-hover table-condensed'  >
	<thead >
	<th class='td_title'>#</th>
	<th class='td_title' >Billboard Company</th>
	<th class='td_title' >Site Name</th>
	<th class='td_title' >Size</th>		
	<th class='td_title' >Faces</th>		
	<th class='td_title' >Description</th>
	<th class='td_title' >Map</th>	
	<th class='td_title' >Actions</th>			
	</tr></thead>";
	 return $titles;
 
}
function javascript_escape($str) {
    $new_str = '';
    $str_len = strlen($str);
    for($i = 0; $i < $str_len; $i++) {
        $new_str .= '\\x' . dechex(ord(substr($str, $i, 1)));
    }
    return $new_str;
}
?>
