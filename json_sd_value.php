<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($aRoutes['paths']['config'].'bs_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$radio_id = $_GET['radio_id'];

$oModel = new BSModel();
$query = "SELECT * FROM desviacion_standard where radio_id = ".$radio_id." order by fecha_hora limit 1;";
$aSD = $oModel->Select($query);
$valor = 0;

foreach ($aSD as $sd) {
	$valor= $sd['valor'];
}

$arr = array(); 

$arr[] = array('value' => $valor/1.0);

echo json_encode($arr);

?>