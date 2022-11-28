<?php 
/*
 * Created on Wed Apr 06 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php');

$id_exercise = htmlspecialchars($_GET['id_exercise']);
$id_training = htmlspecialchars($_GET['id_training']);
$id_training_order = $_GET['id_training_order'];

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch();

if($user_info['permissions_level'] != 1){
    $check_training_user = $bdd->prepare('SELECT COUNT(id_user) as id FROM TRAINING WHERE id_user = ? AND id_training = ?');
    $check_training_user->execute(array($_SESSION['id_user'],$id_training));
    $check_training_user = $check_training_user->fetch();

    if($check_training_user['id'] != 0){
        add_exercise($bdd,$id_exercise,$id_training,$id_training_order);
    }
    else{
        echo "err:Vous n'avez pas la permissions d'ajouter un exercice à un programme d'un autre utilisateur";
    }    
}
else{
    add_exercise($bdd,$id_exercise,$id_training,$id_training_order);
}

function add_exercise($bdd,$id_exercise,$id_training,$id_training_order){
    if($id_training_order == -1){

        $max_exercise = $bdd->prepare('SELECT MAX(exercise_order) AS exercise_order FROM TRAINING_ORDER WHERE id_training = ?');
        $max_exercise->execute(array($id_training));
        $max_exercise_fetch = $max_exercise->fetch();

        if($max_exercise_fetch['exercise_order'] === NULL){
            $max_exercise_fetch['exercise_order'] = 1;
        }
        else{
            $max_exercise_fetch['exercise_order']++;
        }

        $add_exercise = $bdd->prepare('INSERT INTO TRAINING_ORDER(id_training,id_exercise,exercise_order) VALUES (?,?,?)');
        $add_exercise->execute(array($id_training,$id_exercise,$max_exercise_fetch['exercise_order']));
    }
    else{
        $update_exercise = $bdd->prepare('UPDATE TRAINING_ORDER SET id_exercise = ? WHERE id_training = ? AND id_training_order = ?');
        $update_exercise->execute(array($id_exercise,$id_training,$id_training_order));
    }

}
?>