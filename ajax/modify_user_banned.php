
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

if($id != -1 || $id != 1){
    $req = $bdd->prepare("UPDATE OMT_USER SET banned = :banned WHERE id_user = :id");
    if($req->execute(array('banned' => $value,'id' => $id))){
        echo $value;
    }
    else{
        echo "error";
    }
}
else{
    echo "Cette utilisateur ne peux pas être banni";
}

?>

