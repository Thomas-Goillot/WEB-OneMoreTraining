
<?php 
/*
 * Created on Tue Apr 12 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php'); 
$permission = $_GET['permission'];
$id = $_GET['id_user'];
$id_group = $_GET['id_group'];

if($id != -1){
    if($id != $_SESSION['id_user']){
        $req = $bdd->prepare("UPDATE GROUP_RELATIONSHIP SET group_admin = :admin WHERE id_user = :id_user AND id_group = :id_group");
        if($req->execute(array(
            'admin' => $permission,
            'id_user' => $id, 
            'id_group' => $id_group))){
        }
        else{
            echo "error";
        }
    }
    else{
        echo "Vous ne pouvez pas vous bannir";
    }
}
else{
    echo "Cette utilisateur ne peux pas être banni";
}

?>

