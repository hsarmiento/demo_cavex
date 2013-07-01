<?php 
require_once('/var/www/demo_cavex/config/bs_model.php');

$user_id = $_SESSION['user_id'];
$oLogUsuario = new BSModel();
$query_log = "INSERT INTO log_usuarios(user_id, estado_online)VALUES(".$user_id.", 0);";
$oLogUsuario->Select($query_log);
$query_update = "UPDATE usuarios set estado_online = 0 where id = ".$user_id.";";
$oLogUsuario->Select($query_update);



?>