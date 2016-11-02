<?php
include_once 'graph_functions.php';
$chart_title = "Day Time vs Night Time Accidents Analysis between $start_d and $end_d ";
$data_lg = '';
$counties_arr = array();

$day_time_check = " STR_TO_DATE(time, '%H%i') between '06:00:00' and '19:00:00' ";
$night_time_check1 = " STR_TO_DATE(time, '%H%i') >= '19:00:00'";
$night_time_check2 = " STR_TO_DATE(time, '%H%i') <= '06:00:00'";

$sql_counties = "select county cur_county, count(auto_id) cc from accidents_data where county !='' and  $date_qry group by county order by cc desc limit 12";
$res_county = mysqli_query($GLOBALS["___mysqli_ston"], $sql_counties) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
while($rows_county = mysqli_fetch_array($res_county)){
	extract($rows_county);
	$counties_arr[] = $cur_county;
}
$all_counties = implode("','",$counties_arr);
$all_counties = "'$all_counties'";
//exit;
$day_data = '';
$night_data = '';

foreach($counties_arr as $county_cur){
	$day_count = '';
	$total_night_data = $total_day_data = '';
	$sql_day = "select count(auto_id) day_count from accidents_data where county = '$county_cur' and $date_qry and $day_time_check";
	//echo "<hr> $sql_day";
	$res_day = mysqli_query($GLOBALS["___mysqli_ston"], $sql_day) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($rows_day = mysqli_fetch_array($res_day)){
		extract($rows_day);		
	}
	
	if(!isset($day_count)) { 
		$day_count = '0';
	}
	$day_data .= "$day_count,"; 
	
	$night1_count = '';
	$sql_night1 = "select count(auto_id) night1_count from accidents_data where county = '$county_cur' and $date_qry and $night_time_check1";
	//echo "<hr> $sql_night1";
	$res_night1= mysqli_query($GLOBALS["___mysqli_ston"], $sql_night1) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($rows_night1 = mysqli_fetch_array($res_night1)){
		extract($rows_night1);
	}	
	
	$night2_count = '';
	$sql_night2 = "select count(auto_id) night2_count from accidents_data where county = '$county_cur' and $date_qry and $night_time_check2";
	//echo "<hr> $sql_night2";
	$res_night2= mysqli_query($GLOBALS["___mysqli_ston"], $sql_night2) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	if($rows_night2 = mysqli_fetch_array($res_night2)){
		extract($rows_night2);
	}
	
	if(!isset($night1_count) || !isset($night2_count)){
		$night1_count = $night2_count = '0';
	}
	$night_data .= $night1_count + $night2_count . ',';
	
}

	
$graph_data = "{name: 'Day-Time', data: [$day_data]},{name: 'Night-Time', data: [$night_data]}";
$graph_colors = "colors: ['#4387fd ', '#000000'],";

echo column_graph('day_night_graph',$chart_title, $all_counties, $graph_data, $graph_colors);
if($report_type != 'dashboard'){
?>
<div class="row">
<div class = 'col-md-6' id="day_night_pie" style="height: 400px;  "></div>
<?
	$total_day_data = array_sum(explode(',',$day_data));
	$total_night_data = array_sum(explode(',',$night_data));
	
	if($total_day_data > $total_night_data){ 
		$highest_daytime = ",sliced: true,selected: true"; 
		$highest_nighttime = ''; 
		$high_sec ='DayTime';
		$high_val = $total_day_data;
	}else{ 
		$highest_nighttime = ",sliced: true,selected: true"; 
		$highest_daytime = ''; 
		$high_sec ='NightTime';
		$high_val = $total_night_data;
		}

	//echo "Weekday count- $total_weekday_count Weekend count - $total_weekend_count ";
	$pie_data = "{name: 'DayTime', y: $total_day_data $highest_daytime }, {name: 'NightTime', y: $total_night_data $highest_nighttime }";
	$div = 'day_night_pie';
	$pie_title = "Day Time vs Night Time Accidents ranking between $start_d and $end_d";
	$other = '';
	$pie_colors = "colors: ['#4387fd ', '#000000'],";
	echo pie_chart($div,$pie_title, $pie_data, $other,$pie_colors);
?>


<div class = 'col-md-6' id="day_night_pie_info" style=" height:400px; border-left:solid 1px; #CCC; padding-left:2%; overflow-y:scroll; ">
<?
	echo "<center><h4>Analytics Summary</h4> </center>";
	
	echo "
		<ul class='list-group'>
			<li class='list-group-item '>$high_sec's has the highest number of accidents at $high_val accross all counties.</li>
    		
			<li class='list-group-item no-border'>|</li>
			<li class='list-group-item no-border'>|</li>
			<li class='list-group-item no-border'>|</li>
			<li class='list-group-item no-border'></li>
		  </ul>
		";

?>
</div> 
</div> 

<hr>
<? } ?>
<div class="row">
	<div class = 'col-md-12' id="day_night_graph" style="max-width: 90%; height: 500px;  margin:1px; border-radius:4px;"></div>
</div>
