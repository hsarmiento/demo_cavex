<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'routes.php');
require_once($aRoutes['paths']['config'].'bs_login.php');

$oLogin = new BSLogin();
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_control_system/'.'log_leave_website.php');
$oLogin->Logout();
header('Location: index.php');
?>