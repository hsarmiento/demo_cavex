<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");
$is_save = false;

$form = $_POST;
if(!empty($form['save_radio'])){
	if(!empty($form['mac1']) && !empty($form['mac2']) && !empty($form['mac3']) && !empty($form['mac4']) && !empty($form['mac5']) && !empty($form['mac6'])){
		$MAC = $form['mac1'].":".$form['mac2'].":".$form['mac3'].":".$form['mac4'].":".$form['mac5'].":".$form['mac6'];
		$oRadio = new BSModel();
		$query_new_radio = "INSERT INTO radios(mac)values('".$MAC."');";
		$oRadio->Select($query_new_radio);
		$is_save = true;
	}
}


?>

<div class="container container-body">
	<?php if($is_save == true){ ?>
		<div class="alert alert-success" id="success">
		    Saved radio
		</div>
	<?php } ?>
	<h2>Radios</h2>
	<div class="add-radio-text">Add radio</div>
	<div class="container-form-radio">
		<div class="span6 form-div-radio">
			<form class="form-inline" id="add_radio_form" method="post" action="radios.php" enctype="multipart/form-data">
			  <label for="mac1"><strong>Mac address</strong></label>
			  <input type="text" class="input-mini span1" id="mac1" name="mac1"><b>:</b>
			  <input type="text" class="input-mini span1" id="mac2" name="mac2"><b>:</b>
			  <input type="text" class="input-mini span1" id="mac3" name="mac3"><b>:</b>
			  <input type="text" class="input-mini span1" id="mac4" name="mac4"><b>:</b>
			  <input type="text" class="input-mini span1" id="mac5" name="mac5"><b>:</b>
			  <input type="text" class="input-mini span1" id="mac6" name="mac6">
			  <input type="submit" class="btn btn-primary" id="save-radio" name="save_radio" value="Save">
			</form>
		</div>
	</div>	
</div>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>