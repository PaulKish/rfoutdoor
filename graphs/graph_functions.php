<?php
function column_graph($div,$title, $categories, $data, $colors){
	$script = "		
	<script type='text/javascript'>
	$(function () {
		$('#$div').highcharts({
			$colors
			chart: {
				type: 'column'
			},
			title: {
				text: '$title'
			},
			subtitle: {
				text: 'Source: ntsa.go.ke'
			},
			xAxis: {
				categories: [$categories],
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Accidents Count'
				}
			},
			tooltip: {
				headerFormat: '<span style=\'font-size:10px\'>{point.key}</span><table>',
				pointFormat: '<tr><td style=\'color:{series.color};padding:0\'>{series.name}: </td>' +
					'<td style=\'padding:0\'><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [$data]
		});
	});
			</script>			
	";
	return $script;
}
function line_graph($title, $categories, $data){
	$script = "		
		<script type='text/javascript'>
		$(function () {
			$('#line_graph').highcharts({
				title: {
					text: '$title',
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: [$categories]
				},
				yAxis: {
					title: {
						text: 'Accidents Count'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ' accidents'
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [$data]
			});
		});
		</script>		
	";
	return $script;
}
function spline_graph($title, $categories, $data){
	$script = "	
		<script type='text/javascript'>
		$(function () {
			$('#spline_graph').highcharts({
				chart: {
					type: 'spline'
				},
				title: {
					text: '$title'
				},
				subtitle: {
					text: 'Source: ntsa.go.ke'
				},
				xAxis: {
					categories: [$categories]
				},
				yAxis: {
					title: {
						text: 'Accidents Count'
					},
					labels: {
						formatter: function () {
							return this.value + '';
						}
					}
				},
				tooltip: {
					crosshairs: true,
					shared: true
				},
				plotOptions: {
					spline: {
						marker: {
							radius: 4,
							lineColor: '#666666',
							lineWidth: 1
						}
					}
				},
				series: [$data]
			});
		});
	</script>";
	return $script;
}
function pie_chart($div,$title,$data, $other, $pie_colors){
	
	$script = "	
		<script type='text/javascript'>
		$(function () {
			$('#$div').highcharts({
			$pie_colors
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: true,
					type: 'pie'
				},
				title: {
					text: '$title'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				},
				
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						size: 200,
						joe: this.name,
						dataLabels: {
							enabled: true,
							format: '{point.name}: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
								width: '100'
							}
						},
						//start
						point: {
							events: {
								click: function(event) {
									var options = this.options;
									$other
								}
							}
						}
						//end
					}
				},
				
				series: [{
					name: 'County',
					colorByPoint: true,
					data: [$data],
				}]
			});
		});
		</script>
	";
	return $script;
}
?>
