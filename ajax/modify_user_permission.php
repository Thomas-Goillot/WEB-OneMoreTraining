<?php 
/*
 * Created on Sat Apr 09 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
include('../includes/include-bdd.php');

session_start();

$id = htmlspecialchars($_GET['id_user']);
$value = htmlspecialchars($_GET['value']);
$type_permissions = htmlspecialchars($_GET['type_permissions']);

$god_level = [-1,1];

$req = $bdd->prepare('SELECT permissions_level FROM OMT_USER WHERE id_user = :id_user');
$req->execute(array('id_user' => $_SESSION['id_user']));
$donnees = $req->fetch();

if($type_permissions == "admin"){
    if($donnees['permissions_level'] == 1){
        if($_SESSION['id_user'] != $id){
            if(!in_array($id, $god_level)){
                $req = $bdd->prepare("UPDATE OMT_USER SET permissions_level = :perm WHERE id_user = :id");
                $req->execute(array('perm' => $value,'id' => $id));
                echo "val: Permissions modifiées";
            }
            else{
                echo "err: Vous ne pouvez pas modifier le niveau de permission de ce compte";
            }
        }
        else{
            echo "err: Vous ne pouvez pas modifier votre propre niveau de permission";
        }
    }
    else{
        echo "err: Vous n'avez pas les droits nécessaires";
    }
}
elseif($type_permissions == "tools"){
    if($donnees['permissions_level'] == 1){
        if($value >= 2 && $value <= 4){
            $req = $bdd->prepare("UPDATE GIVE_TOOL SET id_subscribe = :perm WHERE id_user = :id");
            $req->execute(array('perm' => $value,'id' => $id));
            echo "val: Permissions modifiées";
        }
        else{
            echo "err: Veuillez entrer un niveau de permission entre 2 et 4";
        }
    }
    else{
        echo "err: Vous n'avez pas les droits nécessaires";
    }
}
else{
    echo "err: Erreur";
}

?>