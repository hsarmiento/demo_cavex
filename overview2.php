
<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
require_once($aRoutes['paths']['config'].'st_model.php');

?>


<div class="container container-body">
	<h2>Overview</h2>
	<div class="hidrociclon"></div>
	<div id="gauge1" class="gauge"></div>
	<div id="gauge2" class="gauge"></div>
	<div id="gauge3" class="gauge"></div>
	<div id="gauge4" class="gauge"></div>
	<div id="gauge5" class="gauge"></div>
	<div id="gauge6" class="gauge"></div>
</div>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>