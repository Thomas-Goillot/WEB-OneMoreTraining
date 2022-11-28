<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');

    $actual_page = "admin/badge.php";

    include('../../includes/include-session-check.php');
    
    include('../../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    if($user_info['permissions_level'] != 1){
        header('Location: ../index.php');
    }


    include('../../includes/include-info.php');

    include('../../includes/include-head.php');

?>
Q
<body class="sb-nav-fixed">

    <?php 
        include('../includes/include-nav-dashboard.php');
    ?>

    <div id="layoutSidenav">

        <?php 
            include('../includes/include-sidenav-dashboard.php');
        ?>

        <main id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard OMT</h1>

                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Informations badges</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="bi bi-tags-fill"></i>
                                Listes des Badges
                            </div>
                            <div class="card-body">
                                <div id="badge_table_msg_box">

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th scope="col">Id</th>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Badge</th>
                                                <th scope="col">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody id="badge_list">
                                            <?php 
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Attribuer badges</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="bi bi-tags-fill"></i>
                                Listes des Utilisateurs
                            </div>
                            <div class="card-body">
                                <div id="badge_table_msg_box">

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Id</th>
                                                <th scope="col">Nom</th>
                                                <th scope="col">badges</th>
                                                <th scope="col">Nombre de badge</th>
                                                <th class="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="badge_list_user">
                                            <?php 
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
                                        </tbody>
                                    </table>
                                    <div id="update_badge_msg_box">
                        
                        </div>     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modify_badge" tabindex="-1" aria-labelledby="modify_badge"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modify_badge">Contenu de la commande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="update_badge" class="modal-body" method="post">
                        <div id="update_badge_msg_box">
                        
                        </div>                            
                        <div id="modify_badge-content">

                        </div>
                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php 
                include('../../includes/include-footer.php');
            ?>
        </main>
        <?php 
                include('../../includes/include-script.php');
            ?>
        <script src="/dashboard/assets/js/dashboard_script.js"></script>
        <script src="js/badge.js"></script>
    </div>
</body>

</html>