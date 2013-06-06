<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

$oModel = new STModel();
$query = "SELECT * FROM parametros order by id desc limit 1;";
$aParametros = $oModel->Select($query);

$form = $_POST;
if(!empty($form)){
	$oModel = new STModel();
	$oAlarms = new STModel();
	if (!isset($form['rms'])){
		$value_rms = 0;
	}else{
		$value_rms = $form['rms'];
		$query_alarms = "INSERT INTO eventos_alarmas(texto)VALUES('Se fija RMS en ".$value_rms."');";
		$oAlarms->Select($query_alarms);
	}
	if (!isset($form['desviacion_standard'])){
		$value_desviacion = 0;
	}else{
		$value_desviacion = $form['desviacion_standard'];
		$query_alarms = "INSERT INTO eventos_alarmas(texto)VALUES('Se fija Desviación Standard en ".$value_desviacion."');";
		$oAlarms->Select($query_alarms);
	}

	$query_save = "INSERT INTO parametros(rms,desviacion_standard)
	VALUES(".$value_rms.",".$value_desviacion.");";
	$oModel->Select($query_save);
}

?>


<div class="container container-body">
	<h2>System Calibration</h2>
	<div class="row">
		<div class="span4"><div class="offset1"><img src="assets/img/bomba.png"></div></div>
		<div class="span2">
			</br>
			<p>
				<strong>Valor actual rms</strong> 
			</p>		
			<span id="rms_calibration"></span></div>
		<div class="span6">
		</br>
			<form name="set_parametros" action="system_calibration.php" id="set_parametros" method="post" enctype="multipart/form-data">
				<p>
					<strong>Mínimo valor rms: </strong> 
				</p>
				<p>
					<input type="text" class="calibration" name="rms" value="<?=$aParametros[0]['rms']?>">
				</p>
				<p>
					<strong>Mínimo valor desviación standard: </strong>
				</p>
			  	<p>  		
					<input type="text" class="calibration" name="desviacion_standard" value="<?=$aParametros[0]['desviacion_standard']?>"
			  	</p>
			  <input type="submit" value="Guardar" class="btn btn-primary btn-large">
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function () {
      $(document).ready(function() {
      	setInterval(function() {
	          var json = $.ajax({
	           url: 'json_calibration.php', // make this url point to the data file
	           dataType: 'json',
	           async: false
	          }).responseText;

	          var dataJson = eval(json);
	          for (var i in dataJson){
	             y_data = dataJson[i].value;                            
	          }
	          y_data = y_data; 
          	$('#rms_calibration').text(y_data);
             // console.log(y_data);
	      }, 3000);
      });
  });


</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>
