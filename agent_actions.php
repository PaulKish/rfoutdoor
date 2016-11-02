<?php
//print_r($_POST);exit;
require_once 'functions.php';
db_con('rf_outdoor');
extract($_POST);

//$agent_name = get_agent_name($raw_id);
if($type=='delete'){
	$sql = "delete from agents where agent_id = $agent_id";
	if(mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)))){
			echo "<hr>Agent User deleted successfully !!!<hr>";
	}else{
		echo "Unable to delete account, Kindly contact System Admin for assistance !!!!";
	}
}elseif($type=='new_agent_submit'){
	//print_r($_POST);exit;
	$exist_sql = "select count(*) count from agents where username = '$username' or email = '$email'";
	$exist_res = mysqli_query($GLOBALS["___mysqli_ston"], $exist_sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		if($raw_log=mysqli_fetch_assoc($exist_res)){
			extract($raw_log);
			if($count > 0){ 
				echo "<hr>Could not create Account Agent User details already exists!!!!! </hr>";
			/*	echo "
				<script type='text/javascript'>
					var agent_id = '0';
					var type = 'new';
					agent_actions(agent_id,type);
					var div_c = '<p>Could not create Account Agent User details already exists!!!!! </p>';
					$('#new_agent_div').append(div_c);
				</script>"; 
			*/
			}else{
				$sql_insert = "insert into agents values(NULL,'$firstname','$lastname','$email','$username',md5('$password'),'$zone_id',NULL,$active)";
				if(mysqli_query($GLOBALS["___mysqli_ston"], $sql_insert)){
					echo "<div><p>Agent Account created Successfully </p><p><strong>Firstname:</strong> $firstname</p>
						<p><strong>Lastname: </strong>lastname</p><p><strong>Username:</strong>$username</p>
						<p><strong>Email: </strong>$email</p><p><strong>Zone ID: </strong>$zone_id</p></div";
				}else{
					echo "Unable to create account, Kindly contact System Admin for assistance !!!!";
				}
			}
		}
}elseif($type=='new'){
	echo "<div class='new_agent' > <h4>New Agent User Account </h4><hr /></div>";
	echo "
		<div id='new_agent_div'>
            <form class='form-horizontal' role='form' data-target='#new_agent_div' data-async id='new_agent_form' method='POST' action='agent_actions.php'>
                <input type='hidden' name='type' value='new_agent_submit' id='action' />
                <div class='form-group'>
                    <label for='firstName' class='col-sm-3 control-label'>First Name</label>
                    <div class='col-sm-9'>
                        <input type='text' id='firstName' name='firstname' placeholder='First Name' class='form-control' autofocus>
                    </div>
                </div>
    			<div class='form-group'>
                    <label for='lastname' class='col-sm-3 control-label'>Second Name</label>
                    <div class='col-sm-9'>
                        <input type='text' id='lastname' name='lastname' placeholder='Last Name' class='form-control' autofocus>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='zone_id' class='col-sm-3 control-label'>Zone ID</label>
                    <div class='col-sm-9'>
                        <input type='text' id='zone_id' placeholder='Zone ID' class='form-control' name='zone_id' autofocus'>
                    </div>
                </div>                
                <div class='form-group'>
                    <label for='email' class='col-sm-3 control-label'>Email</label>
                    <div class='col-sm-9'>
                        <input type='email' id='email' placeholder='Email' class='form-control' name='email'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='username' class='col-sm-3 control-label'>Username</label>
                    <div class='col-sm-9'>
                        <input type='text' id='username' placeholder='Username' class='form-control' name='username'>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='password' class='col-sm-3 control-label'>Password</label>
                    <div class='col-sm-9'>
                        <input type='password' id='password' placeholder='Password' class='form-control' name='password'>
                    </div>
                </div>
              <div class='form-group'>
                    <label for='active' class='col-sm-3 control-label'>Status</label>
                    <div class='col-sm-9'>
                       <select name='active' class='form-control'>
                            <option value='0'>Inactive </option>
                            <option value='1'>Active </option>
                       </select>
                    </div>
                </div>
              
                <div class='form-group'>
                    <div class='col-sm-9 col-sm-offset-3'>
                        <button type='submit' name='submit' class='btn btn-primary btn-block'>Submit</button>
                    </div>
                </div>
            </form> <!-- /form -->
        </div> <!-- ./container -->
	";
}
if($type=='submissions'){
	$page_id = 'submissions';
	echo "<div class='container-fluid row'>";
	include_once 'form_filter.php'; 
	echo "</div><div class='container-fluid row' >";
	include_once 'log_list.php';
	echo "</div><script src='js/jquery-1.12.2.min.js'></script>  ";
	require_once 'footer.php';
	
}
?>

