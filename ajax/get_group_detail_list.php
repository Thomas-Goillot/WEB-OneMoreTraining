<?php 
include('../includes/include-bdd.php'); 
include('../includes/include-functions.php');
$id_group = $_GET['id_group'];

$get_group_detail = $bdd->prepare('SELECT GROUP_RELATIONSHIP.id_user,firstname,surname,group_status,group_admin FROM GROUP_RELATIONSHIP,OMT_USER WHERE id_group = ? AND GROUP_RELATIONSHIP.id_user = OMT_USER.id_user');
$get_group_detail->execute(array($id_group));
$data = $get_group_detail->fetchAll();
for ($i=0; $i < count($data) ; $i++) { 
    echo '<tr class="text-center align-middle">';
    echo '<td>'.$data[$i]['firstname'].'</td>';
    echo '<td>'.$data[$i]['surname'].'</td>';
    echo '<td>'.get_admin_badge($data[$i]['group_admin']).'</td>';
    echo '<td>'.get_group_status($data[$i]['group_status']).'</td>';
    echo '<td>
    <button class="btn btn-link text-warning" data-bs-toggle="modal" data-bs-target="#get_user_group_info" onclick="get_user_group_info('. $id_group.','. $data[$i]['id_user'].')">
        <i class="fa-solid fa-gear"></i>
    </button>
    
    <button class="btn btn-link text-danger" onclick="delete_user_group('. $id_group.','. $data[$i]['id_user'].')">
        <i class="fa-solid fa-trash-can"></i>
    </button>
    </td>';
    echo '</tr>';
}

?>