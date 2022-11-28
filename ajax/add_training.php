<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$name = htmlspecialchars($_GET['name_training']);
$privacy = htmlspecialchars($_GET['privacy']);
$id_user = htmlspecialchars($_GET['id_user']);

if($id_user > 0){
    if(strlen($name) > 0 && strlen($name) <= 50){
        if($privacy > 0 && $privacy <= 3){
            $add_training = $bdd->prepare("INSERT INTO TRAINING(id_user,name_training,privacy_training) VALUES(?,?,?)");
            if($add_training->execute(array($id_user, $name, $privacy))){
                echo "val:Nouveau programme enregistré avec succés";
            }
            else{
                echo "err:Erreur lors de l'enregistrement du programme";
            }
            
        }
        else{
            echo "err: La confidencialité doit être compris entre 1 et 3";
        }
    }
    else{
        echo "err: Le nom ne doit pas dépasser 50 caractères et doit être supérieur à 0";
    }
}
else{
    echo "err: Merci de ne pas modifier le code!";
}



?>