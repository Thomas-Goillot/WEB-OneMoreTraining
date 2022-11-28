<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

    $id_group = htmlspecialchars($_GET['id_group']);
    $column = htmlspecialchars($_GET['column_name']);
    $new_value = htmlspecialchars($_GET['val']);
    
/*     $check_admin = $bdd->prepare('SELECT group_admin FROM GROUP_RELATIONSHIP WHERE id_group = ? AND id_user = ? AND group_admin = 1');
    $check_admin->execute(array($id_group,$_SESSION['id_user']));
    $data = $check_admin->fetch();
    if(!$data){
        $check_admin = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ? AND permissions_level = 1');
        $check_admin->execute(array($_SESSION['id_user']));
        $data = $check_admin->fetch();
        if(!$data){
            echo "Vous n'êtes pas administrateur de ce groupe";
            exit();
        }
    } */
    
switch ($column) {
    case 'group_name':
        $modify_group = $bdd->prepare("UPDATE GROUP_INFO SET group_name = ? WHERE id_group = ?");
        break;
    case 'group_description':
        $modify_group = $bdd->prepare("UPDATE GROUP_INFO SET group_description = ? WHERE id_group = ?");
        break;

    default:
        echo "erreur dans le nom de la colonne";
        break;
}
$modify_group->execute(array($new_value,$id_group));


?>