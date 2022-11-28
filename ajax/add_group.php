<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$name_group = htmlspecialchars($_POST['name_group']);
$id_admin_group = htmlspecialchars($_POST['id_admin_group']);
$description_group = htmlspecialchars($_POST['description_group']);

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch();

if($user_info['permissions_level'] != 1){
    $id_admin_group = $_SESSION['id_user'];
}

$req_user_exist = $bdd->prepare("SELECT id_user FROM OMT_USER WHERE id_user = ?");
$req_user_exist->execute(array($id_admin_group));
$req_user_exist_count = $req_user_exist->rowCount();

if(strlen($name_group) <= 50){
    if(strlen($description_group) <= 255){
        if($req_user_exist_count > 0){

            $add_group = $bdd->prepare("INSERT INTO GROUP_INFO(group_name,group_description) VALUES (:group_name,:group_description)");
            $add_admin = $bdd->prepare("INSERT INTO GROUP_RELATIONSHIP(id_user,id_group,group_status,group_admin) VALUES (:id_user,(SELECT MAX(id_group) FROM GROUP_INFO),1,1)");
            
            if($add_group->execute(['group_name' => $name_group,'group_description' => $description_group])){
                if($add_admin->execute(['id_user' => $id_admin_group,])){
                    echo "val:Nouveau groupe ajouté avec succés!";
                }
                else{
                    echo "err:Erreur lors de l'ajout du groupe";
                }
            }
            else{
                echo "err:Erreur lors de l'ajout du groupe";
            }
  
        }
    }
}



?>