<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

session_start();

include('../includes/include-bdd.php');

$id = $_GET['id_training'];
$new_value = htmlspecialchars($_GET['val']);

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch(); 

if($user_info['permissions_level'] != 1){
    $req_training = $bdd->prepare("UPDATE TRAINING SET name_training = ? WHERE id_training = ? AND id_user = ?");
    $req_training->execute(array($new_value,$id,$_SESSION['id_user']));
}
else{
    $req_training = $bdd->prepare("UPDATE TRAINING SET name_training = ? WHERE id_training = ?");
    $req_training->execute(array($new_value,$id));
}


?>