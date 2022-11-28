
<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
 
include('../includes/include-bdd.php');
include('../includes/include-functions.php');
$req_badge = $bdd->prepare("SELECT * FROM BADGE");
$req_badge->execute();
$badge_info = $req_badge->fetchAll();
    for ($i=0; $i < count($badge_info) ; $i++) { 
        echo '<tr class="text-center align-middle">';
        echo '<td>'.$badge_info[$i]['id_badge'].'</td>';
        echo '<td>'.$badge_info[$i]['name_badge'].'</td>';
        echo '<td>'.get_badge($badge_info[$i]['nb_seance_user_required'],$badge_info[$i]['img_badge']).'</td>';
        echo '<td>'.$badge_info[$i]['description_badge'].'</td>';
        echo '<tr>';
    }                                   
?>