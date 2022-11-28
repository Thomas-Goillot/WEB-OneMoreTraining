<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php');

$id_training = $_GET['id_training'];

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch(); 

try {
    if($user_info['permissions_level'] != 1){
        $check_training_user = $bdd->prepare('SELECT COUNT(id_user) as id FROM TRAINING WHERE id_user = ? AND id_training = ?');
        $check_training_user->execute(array($_SESSION['id_user'],$id_training));
        $check_training_user = $check_training_user->fetch();

        if($check_training_user['id'] != 0){
            $del_training = $bdd->prepare('DELETE FROM TRAINING_ORDER WHERE id_training = ?');
            $del_training->execute(array($id_training));
            echo "val: Tout les exercices du training ont été supprimé!";

            $del_training = $bdd->prepare('DELETE FROM TRAINING WHERE id_training = ?');
            $del_training->execute(array($id_training));
            echo "<br>Le training a été supprimé avec succés";
        }   
        else{
            echo "err:Vous n'avez pas la permissions de supprimé les programme des autres utilisateurs";
        }    
    }
    else{
        $del_training = $bdd->prepare('DELETE FROM TRAINING_ORDER WHERE id_training = ?');
        $del_training->execute(array($id_training));
        echo "val: Tout les exercices du training ont été supprimé!";

        $del_training = $bdd->prepare('DELETE FROM TRAINING WHERE id_training = ?');
        $del_training->execute(array($id_training));
        echo "<br>Le training a été supprimé avec succés";
    }

} catch (\Exception $e) {
    echo "err:$e";
}


?>