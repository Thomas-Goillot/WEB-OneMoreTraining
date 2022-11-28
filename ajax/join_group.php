<?php 
session_start();

include('../includes/include-bdd.php');

$id_group = $_GET['id_group'];

//update group_status to 1 
$update_group_status = $bdd->prepare('UPDATE GROUP_RELATIONSHIP SET group_status = 1 WHERE id_group = ? AND id_user = ?');
$update_group_status->execute(array($id_group,$_SESSION['id_user']));
?>