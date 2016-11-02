</hr>
<div class="row" >
	<div class = 'col-md-6' id="county_comp_pie" style="height: 400px;  border-radius:4px;"></div>
	<div class = 'col-md-6' id="pie_drilldown_list" style=" height:400px; border-radius:4px;"></div> 
</div>
<?
$sql = "select county, count(auto_id) acc_count from accidents_data where county !='' and  $date_qry group by county order by acc_count desc";

$res = mysql_query($sql) or die(mysql_error());
$data = '';
$count = 0;
while($rows=mysql_fetch_assoc($res)){
	extract($rows);
	$count ++;
	if($count == '1'){ $highest = ",sliced: true,selected: true"; $high_count = $county;}
	else{$highest = '';}
	$county = javascript_escape($county);
	$data .= "{name: '$county', y: $acc_count $highest},";
}
//echo "<hr> $data </hr>";
$pie_title =  "County Accidents ranking between $start_d and $end_d  <hr>";
$other = "pie_drilldown(options.name, '$sd', '$ed')";

$div = 'county_comp_pie';
include_once 'graph_functions.php';
$pie_colors = '';
echo pie_chart($div, $pie_title, $data, $other, $pie_colors);
?>
<script type="text/javascript">
	pie_drilldown(<? echo "'$high_count', '$sd', '$ed' "; ?>)
</script>
 