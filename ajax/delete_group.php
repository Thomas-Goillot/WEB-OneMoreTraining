<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$id_group = $_GET['id_group'];

$del_group = $bdd->prepare('DELETE FROM GROUP_RELATIONSHIP WHERE id_group = ?');
$del_group->execute(array($id_group));
echo "val: Tout les utilisateurs du groupe ont été supprimé!";

$del_group = $bdd->prepare('DELETE FROM GROUP_INFO WHERE id_group = ?');
$del_group->execute(array($id_group));
echo "<br>Le groupe a été supprimé avec succés";


?>