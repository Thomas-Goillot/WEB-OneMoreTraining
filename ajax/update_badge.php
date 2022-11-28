<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$req_all_badge = $bdd->prepare("SELECT * FROM BADGE");
$req_all_badge->execute();
$req_all_badge_info = $req_all_badge->fetchAll();

$id_user = htmlspecialchars($_POST['user_id']);

for ($i=1; $i <= count($req_all_badge_info) ; $i++) { 

    $req_user_badge = $bdd->prepare("SELECT id_badge FROM COLLECTED_BADGE WHERE id_user = ? AND id_badge = ?");
    $req_user_badge->execute(array($id_user, $i));
    $req_user_badge_info = $req_user_badge->rowcount();
    

    if(isset($_POST['badge-'.$i.''])){
        if($req_user_badge_info != 1){
            //il a pas le badge on add
            $req_modify_user_badge = $bdd->prepare("INSERT INTO COLLECTED_BADGE(id_user,id_badge) VALUES(?,?)");
            $req_modify_user_badge->execute(array($id_user, $i));
        }

    }
    else{
        if($req_user_badge_info == 1){
            // il a le badge on supp
            $req_modify_user_badge = $bdd->prepare("DELETE FROM COLLECTED_BADGE WHERE id_user = ? AND id_badge = ?");
            $req_modify_user_badge->execute(array($id_user, $i));
        }
    }
}
 echo "val:Modification effectuée avec succés!";

?>