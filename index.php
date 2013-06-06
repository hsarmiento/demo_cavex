<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

?>

<div class="container container-body">
	<div class="row">
		<div class="span6"><div class="offset1"><img src="assets/img/bomba.png"></div></div>
		<div class="span6">
			</br>
			</br>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/demo_cavex/system_calibration.php'">System Calibration</button>
			</p>
			</br>
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