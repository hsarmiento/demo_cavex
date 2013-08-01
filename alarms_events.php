<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin","supervisor");
$checked_all = 'checked="checked"';
$filter_form = $_POST;
if($filter_form['save-filter'] == 'Filter'){
	if($filter_form['all'] == 'on' || (empty($filter_form['all']) && empty($filter_form['hyd']) && empty($filter_form['rad']) && empty($filter_form['user']) && empty($filter_form['sys']))){
		$query = "SELECT * from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id order by fecha_hora desc;";
		$oModel = new BSModel();
		$aEvents = $oModel->Select($query);
	}else{
		$checked_all = "";
		$query = "SELECT * from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id where ";
		$len_query = strlen($query);
		if($filter_form['hyd'] == 'on' && $len_query == strlen($query)){
			$status_hyd = 'tipo = 2 or tipo = 3 or tipo = 4';
			$query = $query.$status_hyd;
			$checked_hyd = "checked = 'checked'";
		}
		if($filter_form['rad'] == 'on'){
			$status_radio = 'tipo = 1 or tipo = 8 or tipo = 9 or tipo = 10';
			if($len_query == strlen($query)){
				$query = $query.$status_radio;
			}else{
				$query = $query.' or '.$status_radio;
			}
			$checked_rad = "checked = 'checked'";		
		}
		if($filter_form['user'] == 'on'){
			$status_user = 'tipo = 5';
			if($len_query == strlen($query)){
				$query = $query.$status_user;
			}else{
				$query = $query.' or '.$status_user;
			}
			$checked_user = "checked = 'checked'";
		}
		if($filter_form['sys'] == 'on'){
			$status_sys = 'tipo = 6 or tipo = 7';
			if($len_query == strlen($query)){
				$query = $query.$status_sys;
			}else{
				$query = $query.' or '.$status_sys;
			}
			$checked_sys = "checked = 'checked'";
		}
		if($len_query < strlen($query)){
			$query = $query.' order by fecha_hora desc;';
			$oModel = new BSModel();
			$aEvents = $oModel->Select($query);
		}
	}
}else{
	$oModel = new BSModel();
	$query = "SELECT * from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id order by fecha_hora desc;";
	$aEvents = $oModel->Select($query);
}

?>
<link rel="stylesheet" href="<? echo $aRoutes['paths']['css']?>jquery-ui-1.10.3.custom.css">

<div class="container container-body">
	<h2>Alarms & Events</h2>
	<div class="row">
		<form class="form-inline" name="filter-alarms-form" action="alarms_events.php" id="filter-alarms-form" method="post" enctype="multipart/form-data">
  			<div class="checkbox checkbox-color">
  				<div class="single-checkbox">
		   			<label>
		      			<input type="checkbox" name="all" <?=$checked_all?> class="form-control">All
		   			</label>
		   		</div>
	   			<div class="single-checkbox">
		   			<label>
		      			<input type="checkbox" name="hyd" <?=$checked_hyd?> class="form-control">Hydrocyclon
		   			</label>
		   		</div>
		   		<div class="single-checkbox">
		   			<label>
		      			<input type="checkbox" name="rad" <?=$checked_rad?> class="form-control">Radios
		   			</label>
		   		</div>
		   		<div class="single-checkbox">
		   			<label>
		      			<input type="checkbox" name="user" <?=$checked_user?> class="form-control">Users
		   			</label>
		   		</div>
  				<div class="single-checkbox">
					<label>
		      			<input type="checkbox" name="sys" <?=$checked_sys?> class="form-control">System
		   			</label>
	   			</div>
		   		<div class="single-checkbox">
		      		<input class="btn btn-primary" type="submit" name="save-filter" id="save-filter" value="Filter"> 
		   		</div>
		   		<label for="from">From</label>
				<input type="text" id="from" name="from" />
				<label for="to">to</label>
				<input type="text" id="to" name="to" />
  			</div>
		</form>
  		<table class="table table-hover table-bordered">
			<thead>
				<tr>
			      <th>Events</th>
			      <th>Datetime</th>
			    </tr>
			</thead>
			<tbody>
				<?php foreach ($aEvents as $value) { ?>
					<tr>
					  <?php
					  	if($value['tipo'] == 1){
				  			$text = 'Detected new radio ';
					  	}elseif($value['tipo'] == 2){
				  			$text = 'Hydrocyclon (MAC '.$value['mac'].') is ropping';
					  	}elseif($value['tipo'] == 3){
					  		$text = 'Hydrocyclon (MAC '.$value['mac'].') is ideal';
					  	}elseif($value['tipo'] == 4){
					  		$text = 'Hydrocyclon (MAC '.$value['mac'].') is semiropping';
					  	}elseif($value['tipo'] == 5){
					  		$text = 'New user added';
					  	}elseif($value['tipo'] == 6){
					  		$text = 'System calibration saved';
					  	}elseif($value['tipo'] == 7){
					  		$text = 'Chart calibration saved';
					  	}elseif($value['tipo'] == 8){
					  		$text = 'New radio added';
					  	}elseif($value['tipo'] == 9){
					  		$text = 'Radio (MAC '.$value['mac'].') disconnected';
					  	}elseif($value['tipo'] == 10){
					  		$text = 'Radio (MAC '.$value['mac'].') removed';
					  	}

					  ?>
				      <td><?=$text?></td>
				      <?php $datetime = strtotime($value['fecha_hora']);?>
				      <td><?=date("l m/d/Y H:i:s", $datetime);?></td>
				    </tr>
				<?php } ?>
		  </tbody>
		</table>
	</div>
</div>


<script>
  $(function() {
    $( "#from" ).datepicker({
      hideIfNoPrevNext: false,
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      showButtonPanel: true,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      showButtonPanel: true,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>