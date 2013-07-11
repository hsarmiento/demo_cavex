<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");
$is_save = 0;

$form = $_POST;
if(!empty($form)){
	$oModel = new BSModel();
	$oAlarms = new BSModel();
	if (!isset($form['rms'])){
		$value_rms = 0;
	}else{
		$value_rms = $form['rms'];
		$query_alarms = "INSERT INTO eventos_alarmas(texto)VALUES('Set rms value ".$value_rms."');";
		$oAlarms->Select($query_alarms);
	}
	if (!isset($form['desviacion_standard'])){
		$value_desviacion = 0;
	}else{
		$value_desviacion = $form['desviacion_standard'];
		$query_alarms = "INSERT INTO eventos_alarmas(texto)VALUES('Set standard desviation value ".$value_desviacion."');";
		$oAlarms->Select($query_alarms);
	}

	if(!isset($form['porcentaje_rms'])){
		$query_save = "INSERT INTO parametros(rms,desviacion_standard)VALUES(".$value_rms.",".$value_desviacion.");";
		$oModel->Select($query_save);
	}else{
		$value_porcentaje = $form['porcentaje_rms'];
		$query_alarms = "INSERT INTO eventos_alarmas(texto)VALUES('Set min rms value ".$value_porcentaje." %');";
		$oAlarms->Select($query_alarms);
		$query_save = "INSERT INTO parametros(rms,desviacion_standard, porcentaje_rms)VALUES(".$value_rms.",".$value_desviacion.",".$value_porcentaje.");";
		$oModel->Select($query_save);
	}
	$is_save = 1;	
}

$oModel = new BSModel();
$query = "SELECT * FROM parametros order by id desc limit 1;";
$aParametros = $oModel->Select($query);


?>


<div class="container container-body">
	<?php if($is_save == 1){ ?>
		<div class="alert alert-success" id="success">
		    Hydrocyclone 1 configuration saved
		</div>
	<?php } ?>
	<h2>System Calibration</h2>
	<div class="row">
		<div class="span5"><img src="assets/img/Setting.png"></div>
		<div class="span7">
			<form name="set_parametros" action="system_calibration.php" id="set_parametros" method="post" enctype="multipart/form-data">
			<div class="controls controls-row">
			    <label class="span2" ><span><strong>Current rms value</strong></span></label>
			    <label class="span2 offset1" ><span><strong>Min rms value</strong></span></label>
			    <label class="span2 offset1"><span><strong>Max rms value(%)</strong></span></label>
			</div>
			<div class="controls controls-row">
			    <strong><span class="span2" id="rms_calibration"></span></strong>
			    <input type="text" class="span2 offset2" class="calibration" name="rms" value="<?=$aParametros[0]['rms']?>"/>
			    <input type="text" class="span2 offset2" class="calibration" name="porcentaje_rms" value="<?=$aParametros[0]['porcentaje_rms']?>"/>
			</div>
				<input style="margin-left:260px; margin-top:10px;" type="submit" value="Save" class="btn btn-primary btn-large">
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
	      }, 1000);
      });
  });


</script>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>