<?php
extract($_POST);
if($page_id == 'user'){
	include 'log_list.php';
}elseif($page_id == 'approved'){
	include 'log_list_processed.php';
}elseif($page_id == 'maps'){
	include 'agent_route.php';
}elseif($page_id == 'analytics'){
	include 'graphs/graphs.php';
}elseif($page_id == 'sites'){
	include 'bb_list.php';
}

?>