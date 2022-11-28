<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
if(isset($_POST['id_product'])){
    $product_id = htmlspecialchars($_POST['id_product']);
}
$product_name = htmlspecialchars($_POST['name_product']);
$product_price = htmlspecialchars($_POST['price_product']);
$product_quantity = htmlspecialchars($_POST['quantity_product']);
$product_description = htmlspecialchars($_POST['description_product']);

if(isset($product_name) || !empty($product_name) || isset($product_price) || isset($product_quantity) || isset($product_description)){
    if(strlen($product_name) <= 50){
        if(is_numeric($product_price)){
            if(is_numeric($product_quantity)){
                if(strlen($product_description) <= 255){

                    $req_add_product = $bdd->prepare("UPDATE PRODUCT p SET p.name =:name,p.price = :price,p.description = :description,p.quantity = :quantity WHERE p.id_product = :id");
                    $req_add_product->execute(
                    [
                        'name' => $product_name,
                        'price' => $product_price,
                        'description' => $product_description,
                        'quantity' => $product_quantity,  
                        'id' => $product_id
                    ]);

                    echo "val:Le produit à été modifé avec succés";
                }
                else{
                    echo "err:Le nom ne doit pas dépasser 255 caractères";
                }
            }
            else{
                echo "err:La quantité n'est pas un nombre";
            }
        }
        else{
            echo "err:Le prix n'est pas un nombre";
        }      
    }
    else{
        echo "err:Le nom ne doit pas dépasser 50 caractères";
    }
}
else{
    echo "err:Vous devez remplir tout les champs";
}

?>