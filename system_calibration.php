<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");
$save = false;

$form = $_POST['radio'];
if(!empty($_POST['save'])){
	$oParametros = new BSModel();
	foreach ($form as $value) {
		$query_save = "INSERT INTO parametros(rms,porcentaje_rms,desviacion_standard, porcentaje_sd, radio_id)values(".$value['rms_normal'].",".$value['rms_max_normal'].", ".$value['sd_normal'].", ".$value['sd_max_normal'].", ".$value['radio_id'].") on duplicate key update rms=".$value['rms_normal'].", porcentaje_rms=".$value['rms_max_normal'].", desviacion_standard=".$value['sd_normal'].", porcentaje_sd=".$value['sd_max_normal'].";";
		// echo $query_save;
		$oParametros->Select($query_save);
		$save = true;
	}
}

$oRadios = new BSModel();
$query_radios = "select radios.id as radio_id, radios.mac as mac, parametros.rms as rms, parametros.porcentaje_rms as porcentaje_rms, parametros.desviacion_standard as desviacion_standard, parametros.porcentaje_sd as porcentaje_sd from radios left join parametros on radios.id = parametros.radio_id where radios.estado = 1;";
$aRadios = $oRadios->Select($query_radios);

?>


<div class="container-body container-calibration">
	<?php if($save === true) { ?>
		<div class="alert alert-success" style="text-align:center;">
	    	Saved settings
	  	</div>
	<?php } ?>
  <h2>System Calibration</h2>
  	  <div class="span12 contenedor">
  	  	<?php if(count($aRadios) > 0) {?>
	  	  	<form name="set_parametros" action="system_calibration.php" id="set_parametros_form" method="post" enctype="multipart/form-data">
		  	  	<?php foreach ($aRadios as $i=>$radio) { ?>
		  	  		<input type="hidden" value="<?=$radio['radio_id']?>" name="radio[<?=$i?>][radio_id]">
		  	  		<div class="span11 offset1 calibration-radio">
				    	<span style="font-size:18px;"><strong>Radio <?=$i+1?>, MAC: <?=$radio['mac']?></strong></span></br></br>
				    	<div class="span1 data-type"><strong>RMS</strong></div>
				    	<div class="span9">	
							<div class="controls controls-row">
							    <label class="span2 offset1" ><span><strong>Current rms value</strong></span></label>
							    <label class="span2 offset1" ><span><strong>Normal rms value</strong></span></label>
							    <label class="span2 offset1"><span><strong>Max rms  normal value(%)</strong></span></label>
							     <label class="span2 offset1"><span><strong>Ropping value(%)</strong></span></label>
							</div>
							<div class="controls controls-row">
							    <strong><span id="rms_calibration<?=$i?>" class="current-value" ></span></strong>
							    <input type="text" class="calibration first-input required" name="radio[<?=$i?>][rms_normal]" value="<?=$radio['rms']?>"/>
							    <input type="text" class="calibration second-input required" name="radio[<?=$i?>][rms_max_normal]" value="<?=$radio['porcentaje_rms']?>"/>
							    <input type="text" class="calibration third-input required" name="radio[<?=$i?>][rms_ropping]" />
							</div>    		
				    	</div>

				    	<div class="span1 data-type"><strong>Standard Deviation</strong></div>
				    	<div class="span9">
							<div class="controls controls-row">
							    <label class="span2 offset1" ><span><strong>Current rms value</strong></span></label>
							    <label class="span2 offset1" ><span><strong>Min rms value</strong></span></label>
							    <label class="span2 offset1"><span><strong>Max rms value(%)</strong></span></label>
							     <label class="span2 offset1"><span><strong>Max rms value(%)</strong></span></label>
							</div>
							<div class="controls controls-row">
							    <strong><span id="rms_calibration<?=$id?>" class="current-value" ></span></strong>
							    <input type="text" class="calibration first-input required" name="radio[<?=$i?>][sd_normal]" value="<?=$radio['desviacion_standard']?>"/>
							    <input type="text" class="calibration second-input required" name="radio[<?=$i?>][sd_max_normal]" value="<?=$radio['porcentaje_sd']?>"/>
							    <input type="text" class="calibration third-input required" name="radio[<?=$i?>][sd_ropping]" value="<?=$aParametros[0]['porcentaje_rms']?>"/>
							</div>						   		
				    	</div>
					</div>	
		  	  	<?php } ?>
		  	  <div class="div-save-calibration">
		  	  	<input type="submit" value="Save" class="btn btn-primary btn-large" name="save" id="save-calibration">
		  	  </div>
		  	  	
		     </form>	 
	    <?php  }?>   	
</div>
</div>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>

<script type="text/javascript">
	    $('#set_parametros_form').validate({
	    	invalidHandler: function(form){
				alert('Red inputs are empty'); // for demo
            	return false; // for demo
			},
	        highlight: function(element, errorClass, validClass) {
			    $(element).addClass(errorClass).removeClass(validClass);
			  },
			 unhighlight: function(element, errorClass, validClass) {
			    $(element).removeClass(errorClass).addClass(validClass);
			  },
			  errorPlacement: function(error, element) {      
        	}
	    });
</script>