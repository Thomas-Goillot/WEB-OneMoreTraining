<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php');

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch(); 

$id_training = $_GET['id_training'];
$id_exercise = $_GET['id_exercise'];
$id_training_order = $_GET['id_training_order'];

if($user_info['permissions_level'] != 1){
    $check_training_user = $bdd->prepare('SELECT COUNT(id_user) as id FROM TRAINING WHERE id_user = ? AND id_training = ?');
    $check_training_user->execute(array($_SESSION['id_user'],$id_training));
    $check_training_user = $check_training_user->fetch();

    if($check_training_user['id'] != 0){
        $req_training = $bdd->prepare("DELETE FROM TRAINING_ORDER WHERE id_training_order = ? AND id_exercise = ?");
        $req_training->execute(array($id_training_order,$id_exercise));
    
        $req_training_exercise = $bdd->prepare("SET @i := 0; UPDATE TRAINING_ORDER SET exercise_order  = (@i := @i + 1) WHERE id_training = ?");
        $req_training_exercise->execute(array($id_training));

        echo "val: L'exercice a été supprimé avec succés";
    
    }
    else{
        echo "err:Vous n'avez pas la permissions de supprimé les exercices d'un programme d'un autre utilisateur";
    }    
}
else{
    $req_training = $bdd->prepare("DELETE FROM TRAINING_ORDER WHERE id_training_order = ? AND id_exercise = ?");
    $req_training->execute(array($id_training_order,$id_exercise));

    $req_training_exercise = $bdd->prepare("SET @i := 0; UPDATE TRAINING_ORDER SET exercise_order  = (@i := @i + 1) WHERE id_training = ?");
    $req_training_exercise->execute(array($id_training));

    echo "val: L'exercice a été supprimé avec succés";
}





?>