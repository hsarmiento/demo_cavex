<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");
$id = $_GET['radio_id'];
if(empty($id)){
	header('Location: radios.php');
}

$oModel = new BSModel();
$is_delete = $oModel->Destroy('radios',array('id' => $id));

if($is_delete===true){
	header('Location: radios.php');
}else{
	header('Location: radios.php');
}


?>