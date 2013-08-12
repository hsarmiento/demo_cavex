<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin","supervisor");

$save_password = $_GET['save_password'];

$query_reader = "SELECT * from estado_lector order by fecha_hora desc limit 1;";
$oModel = new BSModel();
$aReader= $oModel->Select($query_reader);
if($aReader[0]['estado'] == 1){
	$class = 'btn-success reader-running';
	$text = 'Reader running';
}elseif($aReader[0]['estado'] == 0){
	$class = 'btn-info reader-stop';
	$text = 'Reader stopped';
}

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
				<a class="btn btn-default <?=$class?>" id="status-reader" href="#"><?=$text?></a>
			<?php } ?>
			<?php if($_SESSION['usertype'] == 1){?>
				<p>
				  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/cavex_control_system/system_calibration.php'">System Calibration</button>
				</p>
					<button class="btn btn-L btn-primary" type="button" data-toggle="collapse" data-target="#radio_collapse">Radios<b class="caret caret-body"></b></button>
					<div id="radio_collapse" class="collapse" style="margin-bottom:10px">
					  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/cavex_control_system/add_radio.php'">Add radio</button>
				  		<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/cavex_control_system/radios.php'">View radios</button>
				  	</div>	
			<?php } ?>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/cavex_control_system/overview.php'">Overview</button>
			</p>
			<p>
			  <button class="btn btn-L btn-primary" type="button" onclick="window.location.href='/cavex_control_system/alarms_events.php'">Alarms & Events</button>
			</p>
			<?php if($_SESSION['usertype'] == 1){?>
				<p>
				  <button class="btn btn-L btn-primary" type="button" data-toggle="collapse" data-target="#user_collapse">User accounts<b class="caret caret-body"></b></button>
					<div id="user_collapse" class="collapse">
					  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/cavex_control_system/create_user.php'">Create user</button>
					  	<button class="btn btn-sub btn-primary" type="button" onclick="window.location.href='/cavex_control_system/users.php'">View users</button>
				  	</div>
				</p>
			<?php } ?>
			</br>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#status-reader").click(function(){
		if($(this).attr('class') == 'btn btn-default btn-success reader-running'){
			$.ajax({
				url: 'update_reader_status.php?current_status=1',
				success: function(){
					$('#status-reader').removeClass("btn-success").removeClass("reader-running").addClass("btn-info").addClass("reader-stop");
					$('#status-reader').text("Reader stopped");
				}
			});
		}else if($(this).attr('class') == 'btn btn-default btn-info reader-stop'){
			$.ajax({
				url: 'update_reader_status.php?current_status=0',
				success: function(){
					$('#status-reader').removeClass("btn-info").removeClass("reader-stop").addClass("btn-success").addClass("reader-running");	
					$('#status-reader').text("Reader running");
				}
			});
		}
	});


</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'footer.php');

?>
