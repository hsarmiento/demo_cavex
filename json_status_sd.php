<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($aRoutes['paths']['config'].'st_model.php');
$oModel = new STModel();
$query = "SELECT * FROM desviacion_standard order by id desc limit 1;";
$aPrueba = $oModel->Select($query);

// var_dump($aPrueba);

// echo $aPrueba[0]['fecha_hora'];
// $fecha = date('m/d/y h:i a', strtotime($aPrueba[0]['fecha_hora']));
// $todays_date = date('m/d/y h:i a');
// if ($todays_date > $fecha){
// 	echo 'ES MUY VIEJAAA';
// }
// echo $todays_date;
// echo $fecha;
// echo date('m/d/y h:i a', strtotime($aPrueba[0]['fecha_hora']));

$arr = array(); 

$arr[] = array('value' => $aPrueba[0]['valor']/1);

echo json_encode($arr);

// $arr = array(); 

// $arr[] = array('value' => 4);


// echo json_encode($arr);


?>