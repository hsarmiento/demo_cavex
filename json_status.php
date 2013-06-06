<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');



$arr = array(); 

$arr[] = array('value' => 4);


echo json_encode($arr);


?>