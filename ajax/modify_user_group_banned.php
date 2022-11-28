
<?php 
/*
 * Created on Tue Apr 12 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php'); 
$value = $_GET['value'];
$id = $_GET['id_user'];
$id_group = $_GET['id_group'];

if($id != -1){
    if($id != $_SESSION['id_user']){
        $req = $bdd->prepare("UPDATE GROUP_RELATIONSHIP SET group_status = :banned WHERE id_user = :id AND id_group = :id_group");
        if($req->execute(array(
            'banned' => $value,
            'id' => $id, 
            'id_group' => $id_group))){
            echo $value;
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

