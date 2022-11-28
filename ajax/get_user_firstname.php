<?php 
include('../includes/include-bdd.php'); 
$id_user = $_GET['id_user'];
$get_user_info = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
$get_user_info->execute(array($id_user));
$user_info = $get_user_info->fetch();

echo $user_info['firstname'];


?>