<?php
require_once 'functions.php';
db_con('rf_outdoor');
//print_r($_POST); exit;
extract($_POST);

if($agent_id == '0' || $agent_id == ''){
		$agent_qry = ' and agent_id';
	}else{
		$agent_qry = " and agent_id = $agent_id ";
	}

$sql = "select * from raw_logs where raw_id = $raw_id ";
//echo "<hr> $sql <hr>";
$res = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
if($rows=mysqli_fetch_assoc($res)){
	extract($rows);
	$agent_name = get_agent_name($raw_id);
	$bb_co_name = get_bb_co_name($bb_co_id);
	$image_url = "http://reelapp.reelforge.com/rf_outdoor/uploads/" . $photo;
	//echo "<div id='marker_tweet_title' style=''><h4>$agent_name </h4> $date_time </div><hr>";
	echo "<strong>$bb_co_name </strong>	<br> <hr>";	
	
	echo "<div ><img class='img-responsive' src='$image_url' height='600px' /></div>";

}else{
	echo "No Details Found for this entry!!!!";
}

?>