<?php 
session_start();

include('../includes/include-bdd.php');

$id_group = $_GET['id_group'];

$delete_group_relationship = $bdd->prepare('DELETE FROM GROUP_RELATIONSHIP WHERE id_group = ? AND id_user = ?');
$delete_group_relationship->execute(array($id_group,$_SESSION['id_user']));

?>