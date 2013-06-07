<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($aRoutes['paths']['config'].'st_functions_generals.php');

?>

<!DOCTYPE HTML>
<html lang="es">
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<title>Demo</title>
		<link rel="stylesheet" href="<? echo $aRoutes['paths']['css']?>bootstrap.css">
		<link rel="stylesheet" href="<? echo $aRoutes['paths']['css']?>bootstrap_override.css">
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery-ui-1.10.1.custom.min.js"></script>
	</head>
	<body>
		<header>
			<div id="nav-header">
			    <div id="bar-one"></div>
			    <div id="title-nav"><a href="/demo_cavex">Cavex Control System</a></div>
			    <div id="bar-two"></div>
			    <div id="bar-three"></div>
			    <div id="date-nav"><?=date('F /d/Y')?></div>
			</div>
			<div id="sub-nav">
				<div id="middle-sub-nav"></div>
			</div>
			<div class="menu">
				<div class="pull-center">
					<ul class="nav nav-pills">
					  <li><a href="/demo_cavex">Home</a></li>
					  <li><a href="/demo_cavex/system_calibration.php">System calibration</a></li>
					  <li><a href="/demo_cavex/overview.php">Overview</a></li>
					  <li><a href="/demo_cavex/status.php">Status</a></li>
					  <li><a href="/demo_cavex/alarmas_events.php">Alarms & events</a></li>
					</ul>
				</div>
			</div>	
		</header>