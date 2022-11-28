<?php 
/*
 * Created on Sat Apr 09 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$search = htmlspecialchars($_GET['q']);

if(isset($search)){
    $get_users = $bdd->prepare('SELECT * FROM GIVE_TOOL,OMT_USER WHERE OMT_USER.id_user = GIVE_TOOL.id_user AND firstname LIKE ? OR surname LIKE ? OR OMT_USER.id_user LIKE ? GROUP BY OMT_USER.id_user LIMIT 15');
    $get_users->execute(array("$search%","$search%","$search%"));
}
else{
    $get_users = $bdd->prepare('SELECT * FROM GIVE_TOOL,OMT_USER WHERE OMT_USER.id_user = GIVE_TOOL.id_user LIMIT 15');
    $get_users->execute();
}

while($donnees = $get_users->fetch()){
    echo '<tr class="text-center align-middle">';
    echo '<td>'.$donnees['id_user'].'</td>';
    echo '<td>'.$donnees['firstname'].'</td>';
    echo '<td>'.$donnees['surname'].'</td>';
    echo '<td>'.$donnees['mail'].'</td>';
    echo '<td>'.$donnees['phone_number'].'</td>';
    echo '<td class="">

    <div class="form-group">

        <select class="form-control" onchange="change_permissions(this,'.$donnees['id_user'].',\'admin\')">';
            if($donnees['permissions_level'] == 1){
                echo '<option value="1" selected>Administrateur</option>';
            }else{
                echo '<option value="1">Administrateur</option>';
            }
            if($donnees['permissions_level'] == 2){
                echo '<option value="2" selected>User</option>';
            }else{
                echo '<option value="2">User</option>';
            }
    echo '
        </select>
    </div>
    </td>';

    echo '
    <td>
        <div class="form-group">
            <select class="form-control" onchange="change_permissions(this,'.$donnees['id_user'].',\'tools\')">';
                if($donnees['id_subscribe'] == 2){
                    echo '<option value="2" selected>Free</option>';
                }else{
                    echo '<option value="2">Free</option>';
                }
                if($donnees['id_subscribe'] == 3){
                    echo '<option value="3" selected>Premium</option>';
                }else{
                    echo '<option value="3">Premium</option>';
                }
                if($donnees['id_subscribe'] == 4){
                    echo '<option value="4" selected>Ecole</option>';
                }else{
                    echo '<option value="4">Ecole</option>';
                }
    echo '
            </select>
        </div>
    </td>';

    echo '
    <td>
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
