<?php
require_once('functions.php');
extract($_POST);
db_con('tweets2');
//echo "<hr> $report_type <hr>";
if(empty($_POST['sd']) || empty($_POST['ed'])){
	echo "Please select valid Start Date and End Date !!!";
	exit;
}
$start_d = date_format(date_create($sd), 'jS M Y');
$end_d = date_format(date_create($ed), 'jS M Y');

//echo "<h4> $pie_title </h4><hr>";
$date_qry = " date between '$sd' and '$ed' ";

if($report_type == 'dashboard'){

	include_once 'county_date_pie.php';  
	include_once 'county_daily.php'; 
	include_once 'day_night.php'; 
	include_once 'weekday_weekend.php'; 

}elseif($report_type == 'week_end_day'){

	include_once 'weekday_weekend.php'; 

}elseif($report_type == 'day_night'){

	include_once 'day_night.php'; 

}elseif($report_type == 'county_comp'){

	include_once 'county_date_pie.php'; 

}elseif($report_type == 'county_daily'){

	include_once 'county_daily.php'; 
}


//include 'line_graph.php'; 

 ?>
 
<!-- <div class = 'col-md-12' id="line_graph" style="min-width: 310px; height: 400px;  margin: 0 auto"></div>  -->


