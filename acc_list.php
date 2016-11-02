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
	}else{
		$limit_page = $_POST['limit_page'];
		$lmt = $limit_page -1;
	}
	$lmt = $lmt * 10;
	$limit = " limit 10 offset $lmt";
	//echo " | $limit | ";
	//process POST data
	if(!empty($_POST['sd'])){
		$sd=$_POST['sd'];
	}
	if(!empty($_POST['ed'])){
		$ed=$_POST['ed'];
	}

	//Process action types [ Accidents or Non]
	if(!isset($_POST['act_type'])) {
		$_POST['act_type'] = '0' ;
	}
	if($_POST['act_type'] == '0'){
		$act = "";
	}elseif($_POST['act_type'] == '1'){
		$act = " and clean_tweet.predicted_label = 'accident' "; 
	}else{
		$act = " and clean_tweet.predicted_label = 'non_accident' ";
	}

	//Prepare date query
	if(isset($sd) || isset($ed) || !empty($_POST['sd']) || !empty($_POST['ed']) ){
		$date_qry = " date between '$sd' and '$ed' order by date desc, time asc ";
	}else{
		$date_qry = " date desc, time asc ";
	}

	$comp_sd = new DateTime($sd);
	$comp_ed = new DateTime($ed);

	if($comp_sd > $comp_ed){
		$sd = $_POST['ed']; $ed = $_POST['sd']; 
	}

	//Prepare mysql queries
	db_con();
	$num = $lmt + 1 ;
echo get_tweets_titles(); 
	$qry_count = "select count(*) count from accidents_data where $date_qry ";
	//echo "<hr> $qry_count <hr>";
	$results_count = mysqli_query($GLOBALS["___mysqli_ston"], $qry_count) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$row_count = mysqli_fetch_array($results_count);
	$count = $row_count['count']; 

	if($count == 0 || !array_sum($row_count)) { 
		echo "<hr> No Results Found for your search Query!!!!! <hr><div></div>"; 
		
	}else{
		include 'nav_page.php';
		
		$qry = "select * from accidents_data where $date_qry $limit";
		//echo "<hr> $qry <hr>";
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
				<td style='min-width:80px;'>$date_f</td> 
				<td>$time_f</td> 	
				<td>$base_sub_base</td>
				<td>$county</td> 	
				<td>$road</td> 	
				<td>$place</td> 	
				<td>$involved</td> 	
				<td>$description</td> 	
				<td  style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:300px;'>
					<a href='#$num' id='nosub' class='nosub' onclick='PopStuff(\"$auto_id\", \"view\");'>View</a></td> 
				";
				
				if($page_id == 'admin'){
					echo " <td > $predicted_label </td> 
					<td style=''> <a href=''  id='nosub' class='nosub' onclick='PopStuff(\"$tweet_id\", \"edit\");' title='Edit This Entry' >
							<i class='fa fa-pencil-square-o' ></i> 
						</a>| 
					<a href='#'  id='nosub' class='nosub' onclick='PopStuff(\"$tweet_id\", \"delete\");' title='Delete This Entry'>
						<i class='fa fa-times'></i>
					</a></td>";
				}
			echo "</tr>";
			
			//end listing
			$num ++; 
		} 
		echo "</tbody> </table>";
		include 'nav_page.php';
		echo "</div>";
	}

}else{ 
	
	echo "<hr> No Results Found for your search Query!!!!! <hr>"; 
}