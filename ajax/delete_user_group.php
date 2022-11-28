<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$id_group = $_GET['id_group'];
$id_user = $_GET['id_user'];

$del_user_group = $bdd->prepare('DELETE FROM GROUP_RELATIONSHIP WHERE id_user = ? AND id_group = ?');
$del_user_group->execute(array($id_user,$id_group));

echo "val:L'utilisateur a bien été supprimer!";

$req_group = $bdd->prepare("SELECT id_user FROM GROUP_RELATIONSHIP WHERE id_group = ?");
$req_group->execute(array($id_group));
$req_group_total = $req_group->rowCount();

if($req_group_total <= 0){
    $del_group = $bdd->prepare('DELETE FROM GROUP_INFO WHERE id_group = ?');
    $del_group->execute(array($id_group));
    echo "<br><i class='fa-solid fa-circle-exclamation'></i> Comme il n'y avait plus personne dans le groupe celui-ci a été supprimé";
}




?>