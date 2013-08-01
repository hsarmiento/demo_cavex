<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin","supervisor");

$save_password = $_GET['save_password'];

?>

<div class="container container-body">
	<?php if($save_password === 'true') { ?>
		<div class="alert alert-success msg-action" style="text-align:center;">
	    	Successful change password
	  	</div>
	<?php } ?>
	<div class="row">
		<div class="span6"><div class="offset1"><img src="assets/img/bomba.png"></div></div>
		<div class="span6 menu-buttons">
			</br>
			</br>
			<?php if($_SESSION['usertype'] == 1){?>
				<p>
				  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/system_calibration.php'">System Calibration</button>
				</p>
					<button class="btn btn-L btn-primary" type="button" data-toggle="collapse" data-target="#radio_collapse">Radios<b class="caret caret-body"></b></button>
					<div id="radio_collapse" class="collapse" style="margin-bottom:10px">
					  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/demo_cavex/add_radio.php'">Add radio</button>
				  		<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/demo_cavex/radios.php'">View radios</button>
				  	</div>	
			<?php } ?>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/overview.php'">Overview</button>
			</p>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/alarms_events.php'">Alarms & Events</button>
			</p>
			<p>
			  <button class="btn btn-L btn-primary" type="button" data-toggle="collapse" data-target="#user_collapse">User accounts<b class="caret caret-body"></b></button>
				<div id="user_collapse" class="collapse">
				  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/demo_cavex/create_user.php'">Create user</button>
				  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/demo_cavex/users.php'">View users</button>
			  	</div>
			</p>
			</br>
		</div>
	</div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>
