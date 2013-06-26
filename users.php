<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');

$oModel = new BSModel();
$query = "SELECT id,username,nombres,apellidos,telefono, cargo FROM usuarios where permisos = 0 order by nombres asc;";
$aUsers = $oModel->Select($query);

?>


<div class="container container-body">
	<h2>Users</h2>
	<div class="row">
  		<table class="table table-hover table-bordered span9 center-table">
			<thead>
				<tr>
			      <th>User</th>
			      <th>Name</th>
			      <th>Last name</th>
			      <th>Phone</th>
			      <th>Charge</th>
			      <th>Actions</th>
			    </tr>
			</thead>
			<tbody>
				<?php foreach ($aUsers as $value) { ?>
					<tr>
				      <td><?=$value['username']?></td>
				      <td><?=$value['nombres']?></td>
				      <td><?=$value['apellidos']?></td>
				      <td><?=$value['telefono']?></td>
				      <td><?=$value['cargo']?></td>
				      <td>
				      		<div class="edit_div">
				      			<a href="edit_user.php?user_id=<?=$value['id']?>">
									<img src="assets/img/Text-Edit-icon.png" alt="edit user" width="25" height="25" title="edit user">
								</a>
				      		</div>					
							<a href="delete_user.php?user_id=<?=$value['id']?>"  onclick="return confirm('Are you ABSOLUTELY sure?')"><img src="assets/img/DeleteRed.png" alt="delete user" width="25" height="25" title="delete user"></a>						
			      	  </td>
				    </tr>
				<?php } ?>
		  </tbody>
		</table>
	</div>
</div>