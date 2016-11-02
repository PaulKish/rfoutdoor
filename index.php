<? 
	if(!empty($_GET['map'])){
		$page_id = 'maps';
		$page_title = 'View Agent Route Submissions';
	}else{
		$page_id = 'user';
		$page_title = 'View Raw Submissions';
	}
	
	include_once 'header.php' ;
	include_once 'form_filter.php'; 
	include 'footer.php';
	include 'modal_view.php';
?>
	
