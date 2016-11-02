<?php
extract($_POST);
//if(!empty($_POST) ){
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
	
	//Prepare mysql queries
	db_con('rf_outdoor');
	
	echo get_agent_list_titles(); 

	$qry_count = "select count(*) row_count from  agents";
	
	$results_count = mysqli_query($GLOBALS["___mysqli_ston"], $qry_count) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$row_count = mysqli_fetch_array($results_count);
	$count = $row_count['row_count']; 

	if($count == 0 || !array_sum($row_count)) { 
		echo "<hr> No Results Found for your search Query!!!!! <hr><div></div>"; 
		
	}else{
		//include 'nav_page.php';
	
		$qry = "select * from agents ";
		//echo $qry .'<hr />';exit;

		$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		//Table listing
		while($row = mysqli_fetch_array($results))
		{ 
			extract($row);
			//$tweet_time = date_format(date_create($created_at), 'jS, M Y, H:i:s');
			//start listing
			if($active == '0'){
				$active_status = 'In Active';
			}elseif($active == '1'){
				$active_status = 'Active';
			}
			$agent_name = "$firstname $lastname";
			echo "
				<tbody>
				<tr>
				<td><label > $num </label></td> 
				<td>$agent_name</td>
				<td>$created</td>
				<td>$zone_id</td>
				<td>$username</td>
				<td>$email</td>
				<td>$active_status</td>
				<td style='text-align:center;'> <a href='#$num'  class='nosub' onclick='agent_actions(\"$agent_id\", \"submissions\");' title='View Submissions by: $agent_name' >
									<i class='fa fa-search-plus' ></i> 
								</a>
				</td>
				<td style=''> <a href='#$num' class='nosub' onclick='agent_actions(\"$agent_id\", 	 \"edit\");' title='Edit This Entry' >
						<i class='fa fa-pencil-square-o' ></i> 
					</a>| 
				<a href='#'  id='nosub' class='nosub' onclick='agent_actions(\"$agent_id\", \"delete\");' title='Delete This Entry'>
					<i class='fa fa-times' style='color:#D9534F;'></i>
				</a></td>";
			
			//end listing
			$num ++; 
		} 
		echo "</tr> </tbody> </table>";
		//include 'nav_page.php';
		echo "</div>";
	}
/*
else{ 
	echo "<hr> No Results Found for your search Query!!!!! <hr>"; 
}
*/