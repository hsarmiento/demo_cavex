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
		$query_save = "INSERT INTO parametros(rms,porcentaje_rms,desviacion_standard, porcentaje_sd, radio_id)values(".$value['rms_normal'].",".$value['rms_max_normal'].", ".$value['sd_normal'].", ".$value['sd_max_normal'].", ".$value['radio_id'].") on duplicate key update rms=".$value['rms_normal'].", porcentaje_rms=".$value['rms_max_normal'].", desviacion_standard=".$value['sd_normal'].", porcentaje_sd=".$value['sd_max_normal']." order by radios.id asc;";
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
				    	<div class="span9 data-container">	
							<div class="controls controls-row">
							    <label class="span2 offset1">Current rms value</label>
							    <label class="span2 offset1" for="radio[<?=$i?>][rms_normal]" >Normal rms value</label>
							    <label class="span2 offset1" for="radio[<?=$i?>][rms_max_normal]">Max rms  normal value(%)</label>
							     <label class="span2 offset1" for="radio[<?=$i?>][rms_ropping]">Ropping rms value(%)</label>
							</div>
							<div class="controls controls-row">
							    <div id="rms_calibration<?=$i?>" class="current-value" ></div>
							    <input type="text" id="radio[<?=$i?>][rms_normal]" class="calibration first-input required" name="radio[<?=$i?>][rms_normal]" value="<?=$radio['rms']?>"/>
							    <input type="text" class="calibration second-input required" name="radio[<?=$i?>][rms_max_normal]" value="<?=$radio['porcentaje_rms']?>" id="radio[<?=$i?>][rms_max_normal]"/>
							    <input type="text" class="calibration third-input required" name="radio[<?=$i?>][rms_ropping]" id="radio[<?=$i?>][rms_ropping]"/>
							</div>    		
				    	</div>

				    	<div class="span1 data-type"><strong>Standard Deviation (SD)</strong></div>
				    	<div class="span9 data-container">
							<div class="controls controls-row">
							    <label class="span2 offset1" ><span><strong>Current SD value</strong></span></label>
							    <label class="span2 offset1" for="radio[<?=$i?>][sd_normal]">Normal SD value</label>
							    <label class="span2 offset1" for="radio[<?=$i?>][sd_max_normal]">Max SD normal </br>value(%)</label>
							     <label class="span2 offset1" for="radio[<?=$i?>][sd_ropping]">Ropping SD value(%)</label>
							</div>
							<div class="controls controls-row">
							    <div id="sd_calibration<?=$i?>" class="current-value" ></div>
							    <input type="text" class="calibration first-input required" name="radio[<?=$i?>][sd_normal]" value="<?=$radio['desviacion_standard']?>" id="radio[<?=$i?>][sd_normal]"/>
							    <input type="text" class="calibration second-input required" name="radio[<?=$i?>][sd_max_normal]" value="<?=$radio['porcentaje_sd']?>" id="radio[<?=$i?>][sd_max_normal]"/>
							    <input type="text" class="calibration third-input required" name="radio[<?=$i?>][sd_ropping]" value="<?=$aParametros[0]['porcentaje_rms']?>" id="radio[<?=$i?>][sd_ropping]"/>
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

    $(function () {
	      $(document).ready(function() {
	      	var json_radio_id = $.ajax({
		           url: 'json_get_radio_id.php', // make this url point to the data file
		           dataType: 'json',
		           async: false
		          }).responseText;

            var dataJson_radio = eval(json_radio_id);

	      	setInterval(function() {	          
		          var n = 0;
		          var m = 0;
		          for (var i in dataJson_radio){
		             radio_id = dataJson_radio[i].radio_id;
		             var json_rms = $.ajax({
		               url: 'json_rms_value.php?radio_id='+radio_id, 
		               dataType: 'json',
		               async: false
		              }).responseText;

		             var json_sd = $.ajax({
		               url: 'json_sd_value.php?radio_id='+radio_id, 
		               dataType: 'json',
		               async: false
		              }).responseText;

		              var dataJson_rms = eval(json_rms);
		              for (var i in dataJson_rms){
		                 rms = dataJson_rms[i].value; 
		                 $('#rms_calibration'+n.toString()).text(rms); 
		                 n = n + 1;                        
		              }

		              var dataJson_sd = eval(json_sd);
		              for (var i in dataJson_sd){   
		                 sd = dataJson_sd[i].value; 
		                 $('#sd_calibration'+m.toString()).text(sd); 
		                 m = m + 1;                         
		              }
		          }
		      }, 1000);
	      });
	  });



</script>