<?php 
	$pg = $page_id = $_GET['pg'];
	$new = "<div style='float:right'><button class='btn btn-sm btn-primary btn-new-agent'><i class='fa fa-plus'></i> New</button></div>";
	if($pg == 'cos'){
		$page_title = "Manage Billboard Companies $new";
		include_once 'header.php' ;
	}elseif($pg == 'sites'){
		$page_title = "Manage Billboard Sites $new";
		include_once 'header.php' ;
		include_once 'form_filter.php'; 
	}
	
	
	include_once('bb_list.php'); 
	include 'footer.php';
	include 'modal_view.php';
?>
