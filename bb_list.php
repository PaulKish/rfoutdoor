<?php
extract($_POST);
if(isset($pg) && $pg == 'cos'){
	require_once('functions.php');
	db_con('rf_outdoor');
	echo get_bb_co_list_titles(); 
	$qry = "select * from bb_companies order by company_name asc";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$num = 1;
	while($row = mysqli_fetch_array($results))
	{ 
		extract($row);
		echo "
			<tbody>
			<tr>
			<td><label > $num </label></td> 
			<td>$company_name</td>
			<td>$desc</td>
			<td>$created</td>
			<td style='text-align:center;'> <a href='#$num'  class='nosub' onclick='bb_actions(\"$co_id\", \"bb_sites_maps\");' title='View $company_name Billboard Sites' >
				<i class='fa fa-map' ></i> </a>
			</td>
			<td style=''> <a href='#$num' class='nosub' onclick='bb_actions(\"$co_id\", \"edit_bb_co\");' title='Edit This Entry' >
					<i class='fa fa-pencil-square-o' ></i> </a>| 
			<a href='#'  id='nosub' class='nosub' onclick='bb_actions(\"$co_id\", \"delete_bb_co\");' title='Delete This Entry'>
				<i class='fa fa-times' style='color:#D9534F;'></i></a></td>";
		$num ++; 
	} 
	echo "</tr> </tbody> </table></div>";
}elseif((isset($pg) && $pg == 'sites') || (isset($page_id) && $page_id == 'sites') ){
	require_once('functions.php');
	db_con('rf_outdoor');
	echo get_bb_site_list_titles();
	if(isset($bb_co_id )){
		$filter = " where bb_co_id = $bb_co_id  order by site_name";
	}else{	
		$filter = " order by site_name limit 20";
	}
	$num = 1;
	$qry = "select * from billboard_sites $filter";
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	while($row = mysqli_fetch_array($results))
	{ 
		extract($row);
		$bb_co_name = get_bb_co_name($bb_co_id);
		echo "
			<tbody>
			<tr>
			<td><label > $num </label></td> 
			<td>$bb_co_name</td>
			<td>$site_name</td>
			<td>$media_size</td>
			<td>$faces</td>
			<td>$Description</td>
			<td style='text-align:center;'> <a href='#$num'  class='nosub' onclick='bb_actions(\"$id\", \"bb_site\");' title='View $site_name Billboard Sites' >
				<i class='fa fa-map' ></i> </a>
			</td>
			<td style=''> <a href='#$num' class='nosub' onclick='bb_actions(\"$id\", \"edit_bb_co\");' title='Edit This Entry' >
					<i class='fa fa-pencil-square-o' ></i> </a>| 
			<a href='#'  id='nosub' class='nosub' onclick='bb_actions(\"$	id\", \"delete_bb_co\");' title='Delete This Entry'>
				<i class='fa fa-times' style='color:#D9534F;'></i></a></td>";
			
			$num ++;
	}
	echo "</tr> </tbody> </table></div>";
}elseif(!empty($_POST) && $_POST['type'] == 'bb_sites_maps'){
	require_once('functions.php');
	db_con('rf_outdoor');
	$bb_co_id = $_POST['bb_co_id'];
	$qry = "select * from billboard_sites where bb_co_id = $bb_co_id and lattitude is not NULL and longitude is not NULL";
	//echo $qry; exit;
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$data = '';
	$data_r = '';
	while($row = mysqli_fetch_array($results))
	{ 
		extract($row);
		$bb_co_name = get_bb_co_name($bb_co_id);
		$bb_co_name = javascript_escape($bb_co_name);
		$site_name = javascript_escape($site_name);
		$media_size = javascript_escape($media_size);
		$lattitude = javascript_escape($lattitude);
		$longitude = javascript_escape($longitude);
		$id = javascript_escape($id);
		
		$data .= "['$site_name  <br><strong>Company:</strong> $bb_co_name ','$lattitude', '$longitude', '$id','<br><strong>Size:</strong> $media_size']";	
		$data_r .= "['$site_name  <hr> $bb_co_name ','$lattitude', '$longitude', '$id']";	;	
		$data .=',';
		
	}
	//echo "<hr> $data <hr>";
	if(isset($data)){
		require "maps.php";
	}else{
		echo "No location info found for this company sites!!!";
	}

}elseif(!empty($_POST) && $_POST['type'] == 'bb_site'){
	require_once('functions.php');
	db_con('rf_outdoor');
	$bb_co_id = $_POST['bb_co_id'];
	$qry = "select * from billboard_sites where id = $bb_co_id and lattitude is not NULL and longitude is not NULL";
	//echo $qry; exit;
	$results = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	$data = '';
	$data_r = '';
	while($row = mysqli_fetch_array($results))
	{ 
		extract($row);
		$bb_co_name = get_bb_co_name($bb_co_id);
		$bb_co_name = javascript_escape($bb_co_name);
		$site_name = javascript_escape($site_name);
		$media_size = javascript_escape($media_size);
		$lattitude = javascript_escape($lattitude);
		$longitude = javascript_escape($longitude);
		$id = javascript_escape($id);
		
		$data .= "['$site_name  <br><strong>Company:</strong> $bb_co_name ','$lattitude', '$longitude', '$id','<br><strong>Size:</strong> $media_size']";	
		$data_r .= "['$site_name  <hr> $bb_co_name ','$lattitude', '$longitude', '$id']";	;	
		$data .=',';
		
	}
	//echo "<hr> $data <hr>";
	if(isset($data)){
		require "maps.php";
	}else{
		echo "No location info found for this company sites!!!";
	}

}

else{ 
	echo "<hr> No Results Found for your search Query!!!!! <hr>"; 
}