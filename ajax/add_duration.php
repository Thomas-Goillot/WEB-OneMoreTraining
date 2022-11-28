<?php 
/*
 * Created on Wed Apr 06 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$duration = htmlspecialchars($_GET['duration']);
$id_training_order = $_GET['id_training_order'];

/* $autorised = [':','m','M'];

for ($i=0; $i < count($autorised) ; $i++) { 
    echo strpos($autorised[$i],$duration);
}
 */

$update_exercise = $bdd->prepare('UPDATE TRAINING_ORDER SET duration = ? WHERE id_training_order = ?');
$update_exercise->execute(array($duration,$id_training_order));

echo "val:Durée modifié avec succées";

?>