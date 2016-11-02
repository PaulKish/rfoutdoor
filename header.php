<?php
date_default_timezone_set('Africa/Nairobi');
global $page_id ;
require_once('functions.php');

?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reelforge Outdoor</title>
	<link rel="icon" href="favicon.ico">
	<link id="favicon" rel="shortcut icon" href="images/billboard_icon.png" type="image/png" />
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-drawer.css" rel="stylesheet">
	
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="inc/font-awesome-4.5.0/css/font-awesome.min.css"> 
	<link rel="stylesheet" href="css/style.css"> 
	<link rel="stylesheet" href="inc/calendarview.css"> 
	
	<script src='js/jquery-1.12.2.min.js'></script>  
	
</head>
<body >
	<div id="main_container" class="main_container container " >
		<? include_once 'top_nav.php' ; ?>	       
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2" style='margin-top:30; '>
				<? include 'sidebar.php'; ?>
			</div>	 
			<div class="col-md-10" >
				<div class="main"> 
					<div class="panel panel-default page_title" style='margin-top:30;' >
						<div class="panel-body">
							<strong><? echo $page_title; ?> </strong>
						</div>
					</div>
					<div class="table-responsive">


	
