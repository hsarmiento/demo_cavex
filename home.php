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
		<div class="alert alert-success" style="text-align:center;">
	    	Successful change password
	  	</div>
	<?php } ?>
	<div class="row">
		<div class="span6"><div class="offset1"><img src="assets/img/bomba.png"></div></div>
		<div class="span6">
			</br>
			</br>
			<?php if($_SESSION['usertype'] == 1){?>
				<p>
				  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/system_calibration.php'">System Calibration</button>
				</p>
				</br>
			<?php } ?>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/overview.php'">Overview</button>
			</p>
			</br>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/status.php'">Status</button>
			</p>
			</br>

			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/alarmas_events.php'">Alarms & Events</button>
			</p>
		</div>
	</div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>

<script type="text/javascript">
// $(document).ready(function(){
// 	$.ajaxSetup({cache:false});
// 	setInterval(function(){
// 		$('#divRefresh').load('count.php');},1000);
// });	

</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>