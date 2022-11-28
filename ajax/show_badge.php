<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    include('../includes/include-functions.php');
    $id_user = htmlspecialchars($_GET['id']);
?>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr class="text-center align-middle">
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">badges</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        $req_all_badge = $bdd->prepare("SELECT * FROM BADGE");
        $req_all_badge->execute();
        $req_all_badge_info = $req_all_badge->fetchAll();

        for ($i=0; $i < count($req_all_badge_info) ; $i++) { 

            echo '<tr class="text-center align-middle">';

            $req_user_badge = $bdd->prepare("SELECT id_badge FROM COLLECTED_BADGE WHERE id_user = ? AND id_badge = ?");
            $req_user_badge->execute(array($id_user, $req_all_badge_info[$i]['id_badge']));
            $req_user_badge_info = $req_user_badge->rowcount();

            if($req_user_badge_info == 1){
                echo'
                <td>
                    <input class="form-check-input" name="badge-'.$req_all_badge_info[$i]['id_badge'].'" type="checkbox" id="flexCheckDefault" checked>
                </td>';
            }
            else{
                echo'
                <td>
                    <input class="form-check-input" name="badge-'.$req_all_badge_info[$i]['id_badge'].'" type="checkbox" id="flexCheckDefault">
                </td>';
            }

            echo '<td>'.$req_all_badge_info[$i]['name_badge'].'</td>';
            
            echo '<td>'.get_badge($req_all_badge_info[$i]['nb_seance_user_required'],$req_all_badge_info[$i]['img_badge']).'</td>';
            
            echo '</tr>';
        }
        ?>
        <input type="hidden" name="user_id" value="<?=$id_user?>">

        </tbody>
    </table>
</div>