<?php
session_start();

include('../includes/include-bdd.php');

$id_objective = $_GET['id_objective'];

$req_objectives = $bdd->prepare('SELECT id_objective,id_user FROM OBJECTIVE WHERE id_objective = ? AND id_user = ?');
$req_objectives->execute(array($id_objective,$_SESSION['id_user']));
$objective = $req_objectives->rowCount();

if($objective == 1) {
    $req_delete_objective = $bdd->prepare('DELETE FROM OBJECTIVE WHERE id_objective = ?');
    $req_delete_objective->execute(array($id_objective));
}
else{
    echo '<script>alert("Vous n\'avez pas le droit d\'effectuer cette action !");</script>';
}

?>