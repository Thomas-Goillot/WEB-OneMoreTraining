<?php 
// Copyright (c) 2022 Victor STEC

include('../includes/include-bdd.php');

if( !isset($_POST["coupon_id"])){
    die('Il manque des parametres !');
}

if(is_numeric($_POST["coupon_id"])){
    $del = $bdd->prepare("SELECT coupon_id FROM COUPON WHERE coupon_id = ?");
    $del->execute([$_POST["coupon_id"]]);
    $res = $del->fetchAll();

    if(!$res){
        die('Le code n\'existe pas!');
    }

    $req_add_product = $bdd->prepare("DELETE FROM COUPON WHERE coupon_id = ?");
    $req_add_product->execute([$_POST["coupon_id"]]);

    echo "Produit supprimé avec succès";
    exit;
}
exit;

?>