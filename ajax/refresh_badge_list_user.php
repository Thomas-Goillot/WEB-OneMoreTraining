<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    include('../includes/include-functions.php');
    $req_id_user_get_badge = $bdd->prepare("SELECT id_user,firstname FROM OMT_USER WHERE OMT_USER.id_user in (SELECT id_user FROM COLLECTED_BADGE)");
    $req_id_user_get_badge->execute();
    $req_id_user_get_badge_info = $req_id_user_get_badge->fetchAll();

       for ($i=0; $i < count($req_id_user_get_badge_info) ; $i++) { 
           echo '<tr class="text-center align-middle">';
           echo '<td>'.$req_id_user_get_badge_info[$i]['id_user'].'</td>';
           echo '<td>'.$req_id_user_get_badge_info[$i]['firstname'].'</td>';

           $req_id_user_badge = $bdd->prepare("SELECT img_badge,nb_seance_user_required FROM COLLECTED_BADGE,BADGE WHERE id_user = ? AND COLLECTED_BADGE.id_badge = BADGE.id_badge");
           $req_id_user_badge->execute(array($req_id_user_get_badge_info[$i]['id_user']));
           $req_id_user_badge_info = $req_id_user_badge->fetchAll();
           echo '<td>';
               for ($y=0; $y < count($req_id_user_badge_info) ; $y++) { 
                   echo get_badge($req_id_user_badge_info[$y]['nb_seance_user_required'],$req_id_user_badge_info[$y]['img_badge']);
               }
           echo '</td>';
           echo '<td>'.count($req_id_user_badge_info).'</td>';
           echo '<td>
           <button class="btn btn-link text-black" onclick="show_user_badge('.$req_id_user_get_badge_info[$i]['id_user'].')" data-bs-toggle="modal" data-bs-target="#modify_badge"><i class="fa-solid fa-pen-to-square"></i></button>
           </td>';
           echo '<tr>';
        }                                
?>