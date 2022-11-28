<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */



include('../includes/include-bdd.php');
$id = $_GET['id'];
if(is_numeric($id)){
    $req_supp_product = $bdd->prepare("SELECT img FROM PRODUCT WHERE id_product = ?");
    $req_supp_product->execute(array($id));
    $supp_img = $req_supp_product->rowCount();

    if($supp_img <= 1){
        //supprimer image
    }

    $req_add_product = $bdd->prepare("DELETE FROM PRODUCT WHERE id_product = ?");
    $req_add_product->execute(array($id));

    echo "Produit supprimé avec succés";
}
else{
    echo "Merci de ne pas toucher au code de la page !";
}
    

?>