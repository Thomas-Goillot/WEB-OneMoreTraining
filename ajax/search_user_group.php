<?php 
/*
 * Created on Sat Apr 21 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

$search = htmlspecialchars($_GET['q']);
$id_group = $_GET['id_group'];

if(isset($search)){
    $get_users = $bdd->prepare('SELECT id_user,firstname,surname,banned FROM OMT_USER 
    WHERE id_user NOT IN (SELECT id_user FROM GROUP_RELATIONSHIP WHERE id_group = ?) 
    AND firstname LIKE ? 
    OR surname LIKE ? 
    OR id_user LIKE ? 
    ORDER BY id_user 
    LIMIT 10');
    
    $get_users->execute(array($id_group,"$search%","$search%","$search%"));
}
else{
    $get_users = $bdd->prepare('SELECT id_user,firstname,surname,banned FROM OMT_USER WHERE id_user NOT IN (SELECT id_user FROM GROUP_RELATIONSHIP WHERE id_group = ?) ORDER BY id_user LIMIT 10');
    $get_users->execute(array($id_group));
}
echo '
<div class="table-responsive">
    <table class="table table-striped table-sm">
    <thead>
        <tr class="text-center align-middle">
            <th>#</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>ban Status</th>
            <th>Action</th>
        </tr>
    </thead>
    ';
while($donnees = $get_users->fetch()){
    echo '<tr class="text-center align-middle">';
    echo '<td style="width: 8%">'.load_avatar($bdd,$donnees['id_user']).'</td>';
    echo '<td>'.$donnees['firstname'].'</td>';
    echo '<td>'.$donnees['surname'].'</td>';
    echo '<td>';
    if($donnees['banned'] == 0){
        echo '<button class="btn btn-link text-success" disabled><i class="fa-solid fa-user-check"></i></button>';
    }
    else {
        echo '<button class="btn btn-link text-danger" disabled><i class="fa-solid fa-user-times"></i></button>';
    }
    echo'</td>';
    echo '<td><button class="btn btn-link text-dark" onclick="add_user_to_group('.$id_group.','.$donnees['id_user'].')"><i
    class="fa-solid fa-plus"></i></button>';
    echo'</td>';
    echo '<tr>';

}                                                                     
echo "
</div>
</table>";

?>
