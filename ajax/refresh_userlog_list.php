<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');

    $get_users = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level,mail,phone_number,banned FROM OMT_USER LIMIT 15');
    $get_users->execute();
    while($donnees = $get_users->fetch()){
        echo '<tr class="text-center align-middle">';
        echo '<td>'.$donnees['id_user'].'</td>';
        echo '<td>'.$donnees['firstname'].'</td>';
        echo '<td>'.$donnees['surname'].'</td>';
        echo '<td>'.$donnees['mail'].'</td>';
        echo '<td>'.$donnees['phone_number'].'</td>';
        echo '<td class="">
        <div class="form-group">
        <select class="form-control" onchange="change_permissions(this,'.$donnees['id_user'].')">';
        if($donnees['permissions_level'] == 1){
            echo '<option value="1" selected>Administrateur</option>';
        }else{
            echo '<option value="1">Administrateur</option>';
        }
        if($donnees['permissions_level'] == 4){
            echo '<option value="4" selected>Ecole</option>';
        }else{
            echo '<option value="4">Ecole</option>';
        }
        if($donnees['permissions_level'] == 3){
            echo '<option value="3" selected>Premium</option>';
        }else{
            echo '<option value="3">Premium</option>';
        }
        if($donnees['permissions_level'] == 2){
            echo '<option value="2" selected>User</option>';
        }else{
            echo '<option value="2">User</option>';
        }
        echo '
        </div>
        </select>
        </td>';
        echo '<td>
        <a href="profil_show.php?id_user='.$donnees['id_user'].'" class="btn btn-link text-warning"><i class="fa-solid fa-circle-info"></i></a>
        <button class="btn btn-link text-secondary"><i class="fa-solid fa-envelope"></i></button>
        <a class="btn btn-link text-info" href="/ajax/get_user_information_file.php?id_user='.$donnees['id_user'].'"><i class="fa-solid fa-download"></i></a>';
        if($donnees['banned'] == 0){
            echo ' <button class="btn btn-link text-success" onclick="userstatus(this,'.$donnees['id_user'].')"><i class="fa-solid fa-user-check"></i></button>';
        }
        else {
            echo ' <button class="btn btn-link text-danger" onclick="userstatus(this,'.$donnees['id_user'].')"><i class="fa-solid fa-user-times"></i></button>';
        }
        echo'
        </td>';
        echo '<tr>';
    }                                    
?>