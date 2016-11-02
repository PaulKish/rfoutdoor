<?php

//print_r($_POST);
extract($_POST);
//echo $page_id;
if(!empty($_POST) ){
	require_once('functions.php');
	//if(!isset($page_id)) $page_id = 'admin';

	//Pagination Logic
	if(empty($_POST['limit_page']) || $_POST['limit_page'] == '1' ){
		$lmt = 0;
		$num = 1;
	}else{
		$limit_page = $_POST['limit_page'];
		$lmt = $limit_page;
		
	}
	$lmt = $lmt * 10;
	//$num = $lmt + 1;
	$num = 1;
	$limit = " limit $lmt, 10";
	//echo " | $limit | ";
	//process POST data
	if(!empty($_POST['sd'])){
		$sd=$_POST['sd'];
	}
	if(!empty($_POST['ed'])){
		$ed=$_POST['ed'];
	}

	//Prepare date query
	if(isset($sd) || isset($ed) || !empty($_POST['sd']) || !empty($_POST['ed']) ){
		$date_qry = " date(date_time) between '$sd' and '$ed' order by entry_time desc ";
	}else{
		$date_qry = " order by date_time desc $limit";
	}

	$comp_sd = new DateTime($sd);
	$comp_ed = new DateTime($ed);

	if($comp_sd > $comp_ed){
		$sd = $_POST['ed']; $ed = $_POST['sd']; 
	}
	/*
	if($agent_id == '0' || $agent_id == ''){
		$agent_qry = ' agent_id';
	}else{
		$agent_qry = " agent_id = $agent_id ";
	}
	*/
	//Prepare mysql queries
	db_con('rf_outdoor');
	


	$qry_count = "select count(*) raw_count from outdoor_logs where  $date_qry ";
	
	$results_count = mysqli_query($GLOBALS["___mysqli_ston"], $qry_count) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$row_count = mysqli_fetch_array($results_count);
	$count = $row_count['raw_count']; 

	if($count == 0 || !array_sum($row_count)) { 
		echo "<hr> No Results Found for your search Query!!!!! <hr><div></div>"; 
		
	}else{
	
		if($count > 10){
			include 'nav_page.php';
		}
		echo get_processed_logs_titles(); 
		$qry = "select * from outdoor_logs where $date_qry  ";
		//echo $qry .'<hr />';exit;

		$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		//Table listing
		while($row = mysqli_fetch_array($results)){ 
			extract($row);
			//$tweet_time = date_format(date_create($created_at), 'jS, M Y, H:i:s');
			//start listing
			$bb_co_name = get_bb_co_name($bb_co_id);
			$co_name = get_co_name($brand_id);
			$brand_name = get_brand_name($brand_id);
			$comment = get_comment($raw_id);
			$agent_name = get_agent_name($raw_id);
			$title = "Submitted by: $agent_name";
			echo "
			<tbody>
			<tr>
			<td><label > $num </label></td> 
			<td><label > $agent_name </label></td> 
			<td><span title='$title'>$comment</span></td>
			<td>$date_time</td>
			<td>$entry_time</td>
			
			<td  style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:300px;'>
				<a href='#$num' id='nosub' class='nosub' onclick='log_entry_actions(\"$raw_id\", \"map\");'><i class='fa fa-map' ></i></a>
			</td> 
			<td > $bb_co_name </td> 
			<td > $co_name </td> 
			<td > $brand_name </td> 
			<td  style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:300px;'>
				<a href='#$num' id='nosub' class='nosub' onclick='log_entry_actions(\"$raw_id\", \"image\");'><i class='fa fa-file-image-o' ></i></a>
			</td> 
			<td>$bb_size</td>
			<td>$rate</td> ";
			
			$num ++; 
		} 
		echo "</tr> </tbody> </table>";
		//include 'nav_page.php';
		echo "</div>";
	}

}
else{ 
	
	echo "<hr> No Results Found for your search Query!!!!! <hr>"; 
}