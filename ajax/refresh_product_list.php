
<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    $req_product = $bdd->prepare("SELECT * FROM PRODUCT");
    $req_product->execute();
    $product_info = $req_product->fetchAll();

    for ($i=0; $i < count($product_info) ; $i++) { 

        echo '<tr class="text-center align-middle">';
        echo '<td>'.$product_info[$i]['id_product'].'</td>';
        echo '<td>'.$product_info[$i]['name'].'</td>';
        echo '<td>'.$product_info[$i]['price'].' €</td>';
        echo '<td>'.$product_info[$i]['quantity'].'</td>';
        echo '<td>'.explode(" ",$product_info[$i]['added_date'])[0].'</td>';
        echo '<td>
        <button type="button" onclick="get_id_product('.$product_info[$i]['id_product'].')" data-bs-toggle="modal" data-bs-target="#modify_product" class="btn btn-link text-primary"><i class="fa-solid fa-eraser"></i></button>                          
        <button onclick="delete_product('.$product_info[$i]['id_product'].')" class="btn btn-link text-danger"><i class="fa-solid fa-ban"></i></button>
        <button class="btn btn-link text-warning"><i class="fa-solid fa-eye"></i></button>
        </td>';
        echo '<tr>';
    }                  
?>