 <nav class="navbar navbar-default navbar-fixed-top"> 

	  	<div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header" style="padding:3px;">
		      	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		      	</button>
		      	<a class="pull-left"><img src="images/reelforge_logo.png" style="height:50px;" alt="Reelforge"></a>
		    </div>

	    	<!-- Collect the nav links, forms, and other content for toggling -->
	    	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      		<ul class="nav navbar-nav navbar-right">
	      			<?php //if($user->level == 0):?>
					<li><a href="qc.php">QC</a></li>
					<?php //endif; ?>
	        		<li><a href="index.php">TV </a></li>
	        		<li><a href="radio.php">Radio</a></li>
	      			<li><a href="print.php">Print</a></li>
					<li class="active"><a href="/rf_out_of_home">Outdoor <span class="sr-only">(current)</span></a></li>
	      			<li><a href="logout.php">Logout (<? //echo $_SESSION['username']; ?>)</a></li>
	      		</ul>
	    	</div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>

	<!-- <i class="fa fa-align-justify"></i> -->
	
	
	
	