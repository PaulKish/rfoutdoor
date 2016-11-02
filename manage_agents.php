<?php 
	$page_id = 'admin';
	$new = "<div style='float:right'><button class='btn btn-sm btn-primary btn-new-agent'><i class='fa fa-plus'></i> New</button></div>";
	$page_title = "Manage Outdoor Agents $new";
	include_once 'header.php' ;
	include_once('agent_list.php'); 
	include 'footer.php';
	include 'modal_view.php';
?>
