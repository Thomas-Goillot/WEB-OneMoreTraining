<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr class="text-center align-middle">
                <th scope="col">Article</th>
                <th scope="col">Prix Unitaire</th>
                <th scope="col">Quantité</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody id="product_list">


<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
$id = $_GET['id'];

if(is_numeric($id)){
    $req_command = $bdd->prepare("SELECT PRODUCT.name,price,subtotal,PRODUCT_COMMAND.quantity FROM PRODUCT_COMMAND,PRODUCT WHERE id_command = ? AND PRODUCT.id_product = PRODUCT_COMMAND.id_product");
    $req_command->execute(array($id));
    $req_command_info = $req_command->fetchAll();

    for ($i=0; $i < count($req_command_info) ; $i++) { 
        echo '<tr class="text-center align-middle">';
        echo '<td>'.$req_command_info[$i]['name'].'</td>';
        echo '<td>'.$req_command_info[$i]['price'].'</td>';
        echo '<td>'.$req_command_info[$i]['quantity'].'</td>';
        echo '<td>'.$req_command_info[$i]['subtotal'].'</td>';
        echo '<tr>';
    }    

    $req_command = $bdd->prepare("SELECT total_price FROM USER_COMMAND WHERE id_command = ?");
    $req_command->execute(array($id));
    $req_command_info = $req_command->fetchAll();
    echo '<tr class="align-middle">';
    echo '<td>Total</td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td class="text-center align-middle">'.$req_command_info[0]['total_price'].'</td>';   
    echo '</tr>';                      
}
?>
        </tbody>
    </table>
</div>