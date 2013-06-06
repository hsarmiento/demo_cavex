<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'st_model.php');

?>

<div class="container container-body">
	<h2>Alarms & Events</h2>
	<div class="row">
  		<table class="table table-hover table-bordered">
			<thead>
				<tr>
			      <th>Events</th>
			      <th>Datetime</th>
			    </tr>
			</thead>
			<tbody>
			    <tr>
			      <td>Se fija desviación standard en 0.004</td>
			      <td>Martes 15 de Mayo 2013 a las 18:20:09 hrs </td>
			    </tr>
			    <tr>
			      <td>Se ha superado el actual límite de la desviación standard</td>
			      <td>Jueves 17 de Mayo 2013 a las 10:30:09 hrs</td>
			    </tr>
			    <tr>
			      <td>Un hidrociclon entro en semi-ropping</td>
			      <td>Domingo 20 de Mayo 2013 a las 10:30:09 hrs</td>
			    </tr>
		  </tbody>
		</table>
	</div>
</div>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>