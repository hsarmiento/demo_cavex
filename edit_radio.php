<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");

$n_radio = $_GET['n_radio'];
$radio_id = $_GET['radio_id'];

echo $n_radio;
echo $radio_id;

if(empty($n_radio) || empty($radio_id)){
	header("Location: home.php");
}else{
	$oModel = new BSModel();

	$query_radio = "SELECT * from radios where id = ".$radio_id.";";
	$aUsers = $oModel->Select($query);
}

$is_save = false;

// $form = $_POST;
// if(!empty($form['save_radio'])){
// 	if(!empty($form['mac1']) && !empty($form['mac2']) && !empty($form['mac3']) && !empty($form['mac4']) && !empty($form['mac5']) && !empty($form['mac6'])){
// 		$MAC = $form['mac1'].":".$form['mac2'].":".$form['mac3'].":".$form['mac4'].":".$form['mac5'].":".$form['mac6'];
// 		$oRadio = new BSModel();
// 		$query_new_radio = "INSERT INTO radios(mac)values('".$MAC."');";
// 		echo $query_new_radio;
// 		$oRadio->Select($query_new_radio);
// 		header("Location: radios.php?save_radio=true");
// 	}
// }


?>


<div class="container container-body">
	<?php if($is_save == true){ ?>
		<div class="alert alert-success" id="success">
		    Edit radio
		</div>
	<?php } ?>
	<h2>Edit radio <?=$n_radio?></h2>
	<div class="calibration-radio span7 offset2">
		<div class="span6 form-div-radio">
			<form class="form-inline" id="add_radio_form" method="post" action="add_radio.php" enctype="multipart/form-data">
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