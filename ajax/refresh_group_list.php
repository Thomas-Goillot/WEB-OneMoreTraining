<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
session_start();

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

if(isset($_GET['useronly']) && $_GET['useronly'] == "true"){
    $get_group = $bdd->prepare('SELECT * FROM GROUP_INFO,GROUP_RELATIONSHIP WHERE GROUP_RELATIONSHIP.id_user = ? AND GROUP_INFO.id_group = GROUP_RELATIONSHIP.id_group AND GROUP_RELATIONSHIP.group_status = 1');
    $get_group->execute(array($_SESSION['id_user']));

    $get_group_req = $bdd->prepare('SELECT * FROM GROUP_INFO,GROUP_RELATIONSHIP WHERE GROUP_RELATIONSHIP.id_user = ? AND GROUP_INFO.id_group = GROUP_RELATIONSHIP.id_group AND GROUP_RELATIONSHIP.group_status = 2');
    $get_group_req->execute(array($_SESSION['id_user']));
    while($data = $get_group_req->fetch()){
        echo '<tr class="text-center align-middle table-info">';
        echo '<td>'.$data['id_group'].'</td>';
        echo '<td value="'.$data['id_group'].'" name="group_name">'.$data['group_name'].'</td>';
        echo '<td value="'.$data['id_group'].'" name="group_description">'.$data['group_description'].'</td>';
        echo '<td>
        <button class="btn btn-link text-success" onclick="join_group('.$data['id_group'].')"><i class="fa-solid fa-check"></i> Rejoindre </button>
        <button class="btn btn-link text-danger" onclick="decline_group('.$data['id_group'].')">Supprimer <i class="fa-solid fa-xmark"></i></button>
        </td>';
        echo '</tr>';
    }      
}
else{
    $get_group = $bdd->prepare('SELECT * FROM GROUP_INFO');
    $get_group->execute();
}

while($data = $get_group->fetch()){
echo '<tr class="text-center align-middle">';
echo '<td>'.$data['id_group'].'</td>';
echo '<td value="'.$data['id_group'].'" name="group_name">'.$data['group_name'].'</td>';
echo '<td value="'.$data['id_group'].'" name="group_description">'.$data['group_description'].'</td>';
echo '<td>
<button class="btn btn-link text-dark" onclick="get_group_detail('.$data['id_group'].')" data-bs-toggle="modal" data-bs-target="#see_group_detail"><i class="fa-solid fa-eye"></i></button>

<a href="group_user_edit.php?id='.$data['id_group'].'" class="btn btn-link text-warning"><i class="fa-solid fa-pen-to-square"></i></a>

<button class="btn btn-link text-danger" onclick="delete_group('.$data['id_group'].')"><i class="fa-solid fa-trash-can"></i></button>
</td>';
echo '</tr>';
}                                    

?>