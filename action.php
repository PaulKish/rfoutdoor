<?php
require_once 'functions.php';
db_con('rf_outdoor');
extract($_POST);

//print_r($_POST);
if($type == 'action_reject'){
	$sql1 = "delete from outdoor_logs where raw_id = $raw_id";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$sql1 = "update raw_logs set status = 1 where raw_id = $raw_id";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$sql2 = "insert into rejects(raw_id,agent_id,comment) values($raw_id,NULL,'$comment')";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	echo "<div id='submit_feedback'> This submission has been sucessfully rejected. </div>";
}elseif($type == 'action_approve'){
	//print_r($_POST);
	$sql1 = "update raw_logs set status = 2 where raw_id = $raw_id";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$sql2 = "insert into outdoor_logs(raw_id,bb_co_id,bb_size,lattitude,longitude,date_time,photo,brand_id,rate) 
			values($raw_id,$bb_co_id,'$banner_size','$lattitude','$longitude','$capture_time','$photo',$brand_id,'$banner_rate')";
	mysqli_query($GLOBALS["___mysqli_ston"], $sql2) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	echo "<div id='submit_feedback> This submission has been sucessfully approved and tagged. </div>";
}


?>

