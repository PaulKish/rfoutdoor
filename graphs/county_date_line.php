<?php
$chart_title = "Accidents Daily Trend Analysis per county(top 5) between $start_d and $end_d ";
$data_lg = '';
$sql_counties = "select county cur_county, count(auto_id) cc from accidents_data where county !='' and  $date_qry group by county order by cc desc limit 5";
$res_county = mysqli_query($GLOBALS["___mysqli_ston"], $sql_counties) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
while($rows_county = mysqli_fetch_array($res_county)){
	global $county_data , $dates ;
	$county_data = '';
	$startDate =$sdate =  strtotime($sd); 
	$endDate = strtotime($ed); 
	extract($rows_county);
	do{
		$sdate = date ("Y-m-d", $startDate);
		$dates .= "'$sdate',";
		$date_count = '';
		$sql_lg = "select count(auto_id) date_count from accidents_data where
					county = '$cur_county' and date = '$sdate' group by county order by county asc";
		//echo "$sql_lg <hr>";
		$res_lg = mysqli_query($GLOBALS["___mysqli_ston"], $sql_lg) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		$date_count = '';
		if($rows_lg = mysqli_fetch_array($res_lg)){
			extract($rows_lg);
			$county_data .= "$date_count,"; 
		}else{
			//$date_count = '0';
			$county_data .= "0,"; 
		}
			
		$startDate = strtotime('+1 day',$startDate); 
	}while($startDate <= $endDate);
	$data_lg .= "{name: '$cur_county', data: [$county_data]},";
		
}

include_once 'graph_functions.php';
echo column_graph($chart_title, $dates, $data_lg);

?>

