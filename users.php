<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'routes.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'header.php');
// require_once($aRoutes['paths']['config'].'st_functions_generals.php');
require_once($aRoutes['paths']['config'].'bs_model.php');
$oLogin = new BSLogin();
$oLogin->IsLogged("admin");

$oModel = new BSModel();
$query = "SELECT id,username,nombres,apellidos,telefono, cargo, estado_online FROM usuarios where permisos = 0 order by nombres asc;";
$aUsers = $oModel->Select($query);

if($_GET['save_user'] == 'true'){
	$is_save_user = true;
}

?>


<div class="container container-body">
	<?php if($is_save_user === true) { ?>
		<div class="alert alert-success" style="text-align:center;">
	    	User saved
	  	</div>
	<?php } ?>
	<h2>Users Management</h2>
<!-- 	<div class="row">
		<div class="span5 offset4">
			<form class="form-horizontal" id="save_user_online_form" method="post" action="users.php" enctype="multipart/form-data">
				<div class="control-group">
				    <label class="control-label" for="number_users"><strong>Users online</strong></label>
				    <div class="controls">
				      <input type="text" id="number_users" name="number_users" class="span1">
				    </div>
			  	</div>
			  	<input type="submit" class="btn btn-primary save_user_online" value="Save" id="save_user_online">	
			</form>
		</div>
	</div>
</br> -->
	<div class="row">
  		<table class="table table-hover table-bordered span9 center-table">
			<thead>
				<tr>
			      <th>User</th>
			      <th>Name</th>
			      <th>Last name</th>
			      <th>Phone</th>
			      <th>Charge</th>
			      <th>Status</th>
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
				      <?php if($value['estado_online'] == 0){ ?>
							<td><span style="color:red;">Offline</span></td>

				      <?php } elseif ($value['estado_online'] == 1) { ?>
				      		<td><span style="color:green">Online</span></td>
				      <?php }?>
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

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/demo_cavex/'.'footer.php');

?>

<script type="text/javascript">
	$('#number_users').tooltip({'trigger':'hover', 'title': 'Enter only digits', 'placement':'right'});
	$('#save_user_online_form').validate({
		rules:{
			number_users:{
				required: true,
				digits: true
			}
		},
		messages:{
			number_users:{
				required: "Field required",
				digits: "Please enter only digits"
			}
		},
  		errorElement: "div",
        wrapper: "div",  // a wrapper around the error message
        errorPlacement: function(error, element) {
            offset = element.offset();
            error.insertBefore(element)
            error.addClass('error_wrapper');  // add a class to the wrapper
            error.css('position', 'absolute');
            error.css('left', offset.left + element.outerWidth());
            error.css('top', offset.top);
        }
	});

</script>