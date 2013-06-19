<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($aRoutes['paths']['config'].'bs_login.php');

$oLogin = new BSLogin();
session_start();
$oLogin->Logout();
header('Location: index.php');
?>