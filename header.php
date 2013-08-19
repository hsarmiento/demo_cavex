<?php
// require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($aRoutes['paths']['config'].'bs_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_login.php');
$oLogin = new BSLogin();
$oLogin->ExistAnySession();

?>

<!DOCTYPE HTML>
<html lang="es">
	<head>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
		<title>Cavex control system</title>
		<link rel="stylesheet" href="<? echo $aRoutes['paths']['css']?>bootstrap.css">
		<link rel="stylesheet" href="assets/css/bootstrap_override.css" type="text/css" media="all">
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery-ui-1.10.3.custom.js"></script>
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>bootstrap.js"></script>
		<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>jquery.validate.js"></script>
	</head>
	<body>
		<header>
			<div id="nav-header">
			    <div id="bar-one"></div>
			    <div id="title-nav"><a href="/cavex_control_system">Cavex Control System</a></div>
			    <div id="bar-two"></div>
			    <div id="bar-three"></div>
			    <div id="enterprise-nav">Cavex Escondida</div>
			    <div id="date-nav"><?=date('F /d/Y')?></div>
			    <div class="logo_weir"><img src="assets/img/WeirMinerals.png"></div>
			</div>
			<div id="sub-nav">
				<div id="middle-sub-nav"></div>
			</div>
			<div class="menu">
				<div class="pull-center">
					<ul class="nav nav-pills">
					  <li><a href="/cavex_control_system/home.php">Home</a></li>
					  <?php if($_SESSION['usertype'] == 1){?>
						<li><a href="/cavex_control_system/system_calibration.php">System calibration</a></li>
					  	<li class="dropdown">
						  	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Radios<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/cavex_control_system/add_radio.php">Add radio</a></li>
								<li><a href="/cavex_control_system/radios.php">View radios</a></li>
						  	</ul> 
					  </li>
					  <?php } ?>				  
					  <li><a href="/cavex_control_system/overview.php">Overview</a></li>
					  <li><a href="/cavex_control_system/alarms_events.php">Alarms & events</a></li>
					  <?php if($_SESSION['usertype'] == 1){?>
						  <li class="dropdown">
						  	<a class="dropdown-toggle" data-toggle="dropdown" href="#">User accounts <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="create_user.php">Create user</a></li>
								<li><a href="users.php">User Management</a></li>
						  	</ul> 
						  </li>
					  <?php } ?>
					  <li class="dropdown">
					  	<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=$_SESSION['username']?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="change_password.php?user_id=<?=$_SESSION['user_id']?>">Change Password</a></li>
							<li><a href="/cavex_control_system/logout.php">Logout</a></li>
					  	</ul> 
					  </li>
					</ul>
				</div>
			</div>

			<script type="text/javascript">

				$(document).ready(function()
				{
				    setInterval( function() 
				    {	
						$.ajax({
						type: "GET",
						url: "ajax_update_timestamp_online.php?user_id=<?=$_SESSION['user_id']?>"
						});
				    }, 15000);
				});
			</script>
		</header>