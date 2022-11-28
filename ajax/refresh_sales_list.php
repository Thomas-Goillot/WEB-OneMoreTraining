<?php /*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();
$info = $_GET['info'];

include('../includes/include-bdd.php');

if($info == "alluser"){
    $req_sales_all = $bdd->prepare("SELECT * FROM USER_COMMAND ORDER BY date_of_purchase DESC");
    $req_sales_all->execute();
    $sales_info = $req_sales_all->fetchAll();
    for ($i=0; $i < count($sales_info) ; $i++) { 
        echo '<tr class="text-center align-middle">';
        echo '<td>'.$sales_info[$i]['id_command'].'</td>';
        echo '<td>'.$sales_info[$i]['date_of_purchase'].'</td>';
        echo '<td>'.$sales_info[$i]['total_price'].' €</td>';
        echo '<td>'.$sales_info[$i]['id_user'].'</td>';
        echo '<td><button class="btn btn-link text-warning" onclick="get_command_detail('.$sales_info[$i]['id_command'].')" data-bs-toggle="modal" data-bs-target="#see_command_detail"><i class="fa-solid fa-eye"></i></button></td>';
        echo '<tr>';
    }   
}
else{
    $req_sales_all = $bdd->prepare("SELECT * FROM USER_COMMAND WHERE id_user = ? ORDER BY date_of_purchase DESC");
    $req_sales_all->execute(array($_SESSION['id_user']));
    $sales_info = $req_sales_all->fetchAll();

    for ($i=0; $i < count($sales_info) ; $i++) { 
        echo '<tr class="text-center align-middle">';
        echo '<td>'.$sales_info[$i]['id_command'].'</td>';
        echo '<td>'.$sales_info[$i]['date_of_purchase'].'</td>';
        echo '<td>'.$sales_info[$i]['total_price'].' €</td>';
        echo '<td><button class="btn btn-link text-warning" onclick="get_command_detail('.$sales_info[$i]['id_command'].')" data-bs-toggle="modal" data-bs-target="#see_command_detail"><i class="fa-solid fa-eye"></i></button></td>';
        echo '<tr>';
    }   
}


                                                
?>