<?php 
include('../includes/include-bdd.php'); 
include('../includes/include-functions.php');

$id_user = $_GET['id_user'];
$id_group = $_GET['id_group'];

$check_user_in_group = $bdd->prepare('SELECT id_user FROM GROUP_RELATIONSHIP WHERE id_user = ? AND id_group = ?');
$check_user_in_group->execute(array($id_user,$id_group));
$check_user_in_group = $check_user_in_group->fetch();

if(!isset($check_user_in_group['id_user'])){
    $add_user_to_group = $bdd->prepare('INSERT INTO GROUP_RELATIONSHIP (id_user,id_group,group_status,group_admin) VALUES (?,?,?,?)');
    $add_user_to_group->execute(array($id_user,$id_group,2,0));
}
else{
    echo "User already in group";
}


?>