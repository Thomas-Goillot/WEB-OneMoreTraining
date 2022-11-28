<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$product_name = htmlspecialchars($_POST['name_product']);
$product_price = htmlspecialchars($_POST['price_product']);
$product_quantity = htmlspecialchars($_POST['quantity_product']);
$product_description = htmlspecialchars($_POST['description_product']);

if(isset($product_name) || !empty($product_name) || isset($product_price) || isset($product_quantity) || isset($product_description)){
    if(strlen($product_name) <= 50){
        if(is_numeric($product_price)){
            if(is_numeric($product_quantity)){
                if(strlen($product_description) <= 255){
                    if($_FILES['image_product']['error'] != 4){

                        $acceptable = ['image/jpeg','image/png'];
                    
                        if(in_array($_FILES['image_product']['type'], $acceptable)){
                            $maxSize = 2 * 1024 * 1024; // 2Mo
                    
                            if($_FILES['image_product']['size'] < $maxSize){

                                // Si le dossier product n'esist pas, le créer
                                $path = '../assets/img/product';
                                if(!file_exists($path)){
                                    mkdir($path, 0777); // chmod 777
                                }
                            
                                $filename = htmlspecialchars($_FILES['image_product']['name']);

                                $array = explode('.', $filename);
                                $extension = end($array);
                            
                                $filename = 'product-' . time() . '.' . $extension;
                            
                                $destination = $path . '/' . $filename;

                                move_uploaded_file($_FILES['image_product']['tmp_name'], $destination);

                                add_filigrane($filename,"product");

                                $req_add_product = $bdd->prepare("INSERT INTO PRODUCT (name,price,description,img,quantity) VALUES(:name,:price,:description,:img,:quantity)");
                                $req_add_product->execute(
                                [
                                    'name' => $product_name,
                                    'price' => $product_price,
                                    'description' => $product_description,
                                    'img' => $filename,
                                    'quantity' => $product_quantity,  
                                ]);

                                echo "val:Le produit à été ajouté avec succés";
                            }
                            else{
                                echo "err:L'image ne doit pas dépasser 2Mo";
                            }
                        }
                        else{
                            echo "err:Type d'image incorrect";
                        }
                    }
                    else{
                        echo "err:Pas d'image detecter";
                    }
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