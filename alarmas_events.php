<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin","supervisor");
$oModel = new BSModel();
$query = "SELECT * FROM eventos_alarmas order by id desc;";
$aEvents = $oModel->Select($query);

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
				<?php foreach ($aEvents as $value) { ?>
					<tr>
				      <td><?=$value['texto']?></td>
				      <?php $datetime = strtotime($value['fecha_hora']);?>
				      <td><?=date("l m/d/Y H:i:s", $datetime);?></td>
				    </tr>
				<?php } ?>
		  </tbody>
		</table>
	</div>
</div>


<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>