<?php
//global $page_id ;
//echo $page_id;

if(!empty($_POST['sd'])){
	$sd=$_POST['sd'];
}else{
	$sd = date('Y-m-d');
}
if(!empty($_POST['ed'])){
	$ed=$_POST['ed'];
}else{
$ed = date('Y-m-d');
}
if(!empty($_POST['act_type'])){
	$act_type=$_POST['act_type'];
}else{
$act_type = 0;
}
?>

<div id='form_sel' class='form_sel'>
	<form class="form-inline" id="date_select" method="POST">
		<? if(empty($_GET['pg']) ){ ?>
		<div class="input-group">
			<div class="input-group-addon"><label for="agent_id">Start: </label> <i class="fa fa-calendar"></i></div>
			<input class="form-control" id="date" name="sd" placeholder="YYYY-MM-DD" type="text" value="<?php echo  $sd; ?>"/>
		</div>
		<div class="input-group">
			<div class="input-group-addon"><label for="agent_id">End: </label> <i class="fa fa-calendar"></i></div>
			<input class="form-control" id="date" name="ed" placeholder="YYYY-MM-DD" type="text" value="<?php echo $ed; ?>"/>
		</div>
		<? if($page_id != 'approved' || $page_id !='submissions'){ ?>
			<div class="input-group">
				<div class="input-group-addon"><label for="agent_id">Agent: </label> <i class='fa fa-user' ></i> </div>
				<?= get_agent_users(); ?>
			</div>
		<? } }else{?>
		
		<div class="input-group">
				<div class="input-group-addon"><label for="agent_id">BillBoard Company: <img src='images/billboard_icon.png' height='15px' /></div>
				<?= get_bb_companies(); ?>
				<input type='hidden' name='page_id' value='<? echo $page_id; ?>' />
			</div>
		  <?php  }?>
		  <input type='hidden' name='limit_page' value='1' />
		  <input type='hidden' name='page_id' value='<? echo $page_id; ?>' />
		  <input type='hidden' name='report_type' value='<? //echo $report_type; ?>' />
		  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>

<div class='listing table-responsive' id='listing' >