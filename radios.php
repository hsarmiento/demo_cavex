<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$oLogin = new BSLogin();
$oLogin->IsLogged("admin");

$oModel = new BSModel();
$query_radios = "SELECT * from radios order by id asc;";
$aRadios = $oModel->Select($query_radios);


$is_save = $_GET['save_radio'];
// print_r($aRadios);

?>



<div class="container container-body">
	<?php if($is_save == 'true'){ ?>
		<div class="alert alert-success" id="success">
		    Saved radio
		</div>
	<?php } ?>
	<h2>Radios</h2>
	<div class="row">
  		<table class="table table-hover table-bordered span9 center-table">
			<thead>
				<tr>
			      <th>MAC address</th>
			      <th>Status</th>
			      <th>Actions</th>
			    </tr>
			</thead>
			<tbody>
				<?php $i = 1;?>
				<?php foreach ($aRadios as $radio) { ?>
					<tr>
				      <td><?=$radio['mac']?></td>
				      <?php if($radio['estado'] == 0){ ?>
							<td><span style="color:red;">Disconnected</span></td>

				      <?php } elseif ($radio['estado'] == 1) { ?>
				      		<td><span style="color:green">Connected</span></td>
				      <?php }?>
				      <td>
				      		<div class="edit_div">
				      			<a href="edit_radio.php?radio_id=<?=$radio['id']?>&n_radio=<?=$i?>">
									<img src="assets/img/Text-Edit-icon.png" alt="edit user" width="25" height="25" title="edit user">
								</a>
				      		</div>					
							<a href="delete_radio.php?radio_id=<?=$radio['id']?>" onclick="return confirm('Are you ABSOLUTELY sure?')"><img src="assets/img/DeleteRed.png" alt="delete user" width="25" height="25" title="delete user"></a>
			      	  </td>
				    </tr>
				    <?php $i = $i + 1;?>
				<?php } ?>
		  </tbody>
		</table>
	</div>
</div>