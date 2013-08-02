<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin","supervisor");
$checked_all = 'checked="checked"';
$filter_form = $_POST;
if($filter_form['save-filter'] == 'Filter'){
	if($filter_form['all'] == 'on' || (empty($filter_form['all']) && empty($filter_form['hyd']) && empty($filter_form['rad']) && empty($filter_form['user']) && empty($filter_form['sys']))){
		if(!empty($filter_form['from_date']) and !empty($filter_form['to_date'])){
			$query = "SELECT radios.radio_id, radios.mac, eventos_alarmas.tipo as tipo, eventos_alarmas.fecha_hora as fecha_hora from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id where fecha_hora >= '".$filter_form['from_date']."' and fecha_hora <= '".$filter_form['to_date']."' order by fecha_hora desc;";
		}else{
			$query = "SELECT radios.radio_id, radios.mac, eventos_alarmas.tipo as tipo, eventos_alarmas.fecha_hora as fecha_hora from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id order by fecha_hora desc;";
		}
		$oModel = new BSModel();
		$aEvents = $oModel->Select($query);
	}else{
		if(!empty($filter_form['from_date']) and !empty($filter_form['to_date'])){
			$query = "SELECT radios.radio_id, radios.mac, eventos_alarmas.tipo as tipo, eventos_alarmas.fecha_hora as fecha_hora from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id where fecha_hora >= '".$filter_form['from_date']."' and fecha_hora <= '".$filter_form['to_date']."' and ( ";
		}else{
			$query = "SELECT radios.radio_id, radios.mac, eventos_alarmas.tipo as tipo, eventos_alarmas.fecha_hora as fecha_hora from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id where ";
		}

		$checked_all = "";
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
			$status_sys = 'tipo = 6 or tipo = 7 or tipo = 11';
			if($len_query == strlen($query)){
				$query = $query.$status_sys;
			}else{
				$query = $query.' or '.$status_sys;
			}
			$checked_sys = "checked = 'checked'";
		}
		
		if($len_query < strlen($query)){
			if(!empty($filter_form['from_date']) and !empty($filter_form['to_date'])){
				$query = $query.') order by fecha_hora desc;';
			}else{
				$query = $query.' order by fecha_hora desc;';
			}		
			$oModel = new BSModel();
			$aEvents = $oModel->Select($query);
		}
	}
}else{
	$oModel = new BSModel();
	$query = "SELECT radios.id as radio_id, radios.mac as mac, eventos_alarmas.tipo as tipo, eventos_alarmas.fecha_hora as fecha_hora from eventos_alarmas left join radios on eventos_alarmas.radio_id = radios.id order by fecha_hora desc;";
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
	   			<div class="single-checkbox" id="from_date_div">
		   				<input type="text" class="date_alert" id="from_date" name="from_date" placeholder="From" value="<?=$filter_form['from_date']?>"/>
		   		</div>
		   		<div class="single-checkbox" id="to_date_div">
		   				<input type="text" class="date_alert" id="to_date" name="to_date" placeholder="To" value="<?=$filter_form['to_date']?>"/>
		   		</div>
		   		<div class="single-checkbox">
		      		<input class="btn btn-primary" type="submit" name="save-filter" id="save-filter" value="Filter"> 
		   		</div>
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
				  			$text = 'Detected new radio (MAC '.$value['mac'].')';
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
					  		$text = 'RMS chart calibration saved';
					  	}elseif($value['tipo'] == 8){
					  		if(!empty($value['radio_id'])){
					  			$text = 'New radio (MAC '.$value['mac'].') added';
					  		}else{
					  			$text = 'New radio added';
					  		}					  		
					  	}elseif($value['tipo'] == 9){
					  		$text = 'Radio (MAC '.$value['mac'].') disconnected';
					  	}elseif($value['tipo'] == 10){
					  		$text = 'Radio removed';
					  	}elseif($value['tipo'] == 11){
					  		$text = 'SD chart calibration saved';
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


<script type="text/javascript">
  $(function() {
    $( "#from_date" ).datepicker({
      showOn: "both",
      buttonImage: "assets/img/calendar.gif",
      buttonImageOnly: true,
      dateFormat: "yy-mm-dd",
      hideIfNoPrevNext: false,
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      showButtonPanel: true,
      showAnim: "fadeIn", 
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
      showOn: "both",
      buttonImage: "assets/img/calendar.gif",
      buttonImageOnly: true,
      dateFormat: "yy-mm-dd",
      hideIfNoPrevNext: false,
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      showButtonPanel: true,
      showAnim: "fadeIn",
      onClose: function( selectedDate ) {
        $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>