<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'routes.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$query_status = 'insert into estado_lector(estado)values(0);';
$oModel = new BSModel();
$oModel->Select($query_status);

require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'logout.php');
// system("echo 'legend' | sudo -S reboot");

?>