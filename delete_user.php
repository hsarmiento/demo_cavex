<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$id = $_GET['user_id'];
if(empty($id)){
	header('Location: users.php');
}

$oModel = new BSModel();
$is_delete = $oModel->Destroy('usuarios',array('id' => $id));

if($is_delete===true){
	header('Location: users.php');
}


?>