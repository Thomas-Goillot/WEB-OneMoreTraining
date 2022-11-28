<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../../includes/include-bdd.php');

$actual_page = "admin/index.php";

include('../../includes/include-session-check.php');

include('../../includes/include-functions.php');

$req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch(); 

if($user_info['permissions_level'] != 1){
    header('Location: ../../index.php');
}


include('../../includes/include-info.php');

include('../../includes/include-head.php');

?>

<body class="sb-nav-fixed">
    <?php 
        include('../includes/include-nav-dashboard.php');
    ?>

    <div id="layoutSidenav">
        <?php 
        include('../includes/include-sidenav-dashboard.php');
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard OMT</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Informations principales</li>
                    </ol>
                    <div class="row" id="userlog_header">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5>Nombre de visite total des utilisateurs aujourd'hui:</h5>
                                    <?php 
                                        $req_users = $bdd->prepare("SELECT COUNT(date_connection) FROM USER_VISIT WHERE DATE(date_connection) = ?");
                                        $req_users->execute(array(date('Y-m-d')));
                                        $visit_today = $req_users->fetchAll();

                                        $req_users2 = $bdd->prepare("SELECT COUNT(date_of_activity) as log FROM USER_LOG WHERE DATE(date_of_activity) = ? AND id_user = -1");
                                        $req_users2->execute(array(date('Y-m-d')));
                                        $visit_today2 = $req_users2->fetchAll();

                                        $temp = $visit_today[0]['COUNT(date_connection)'] + $visit_today2[0]['log'];

                                        echo "<h1 class='text-align'>". $temp ." <i class='fa-solid fa-eye'></i></h1>";
                                    ?>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Voir en détails</a>
                                    <div class="small text-white"><i class="bi bi-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5>Nombre de visite utilisateurs inscrit aujourd'hui:</h5>
                                    <?php 
                                        $req_users = $bdd->prepare("SELECT COUNT(date_connection) FROM USER_VISIT WHERE DATE(date_connection) = ? AND id_user > 0");
                                        $req_users->execute(array(date('Y-m-d')));
                                        $visit_today = $req_users->fetchAll();
                                        echo "<h1 class='text-align'>".$visit_today[0]['COUNT(date_connection)']." <i class='fa-solid fa-eye'></i></h1>";
                                    ?>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Voir en détails</a>
                                    <div class="small text-white"><i class="bi bi-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5>Nombre de visite utilisateurs non inscrit aujourd'hui:</h5>
                                    <?php 
                                        $req_users = $bdd->prepare("SELECT COUNT(date_of_activity) FROM USER_LOG WHERE DATE(date_of_activity) = ? AND id_user = -1");
                                        $req_users->execute(array(date('Y-m-d')));
                                        $visit_today = $req_users->fetchAll();
                                        echo "<h1 class='text-align'>".$visit_today[0]['COUNT(date_of_activity)']." <i class='fa-solid fa-eye'></i></h1>";
                                    ?>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Voir en détails</a>
                                    <div class="small text-white"><i class="bi bi-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h5>Nombre de visite utilisateurs ce mois-ci:</h5>

                                    <?php 
                                        $req_users = $bdd->prepare("SELECT date_connection FROM USER_VISIT WHERE MONTH(date_connection) = ? AND YEAR(date_connection) = ?");
                                        $req_users->execute(array(date('m'), date('Y')));
                                        $visit_this_month = $req_users->rowCount();
                                        echo "<h1 class='text-align'>$visit_this_month  <i class='fa-solid fa-eye'></i></h1>";
                                    ?>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">Voir en détails</a>
                                    <div class="small text-white"><i class="bi bi-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Utilisateurs</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="bi bi-table"></i>
                            Listes Utilisateurs

                            <input type="text" class="form-control float-end" id="search-user" onkeyup="search_user()"
                                placeholder="Chercher un utilisateur" style="width: 40%">
                        </div>
                        <div class="card-body">
                            <div id="userlog_list_msg_box">

                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>Id</th>
                                            <th>Nom <i class="fa-solid fa-sort"></i></th>
                                            <th>Prènom <i class="fa-solid fa-sort"></i></th>
                                            <th>Mail</th>
                                            <th>N°Téléphone</th>
                                            <th>Permissions</th>
                                            <th>Abonnements</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userlog_list" style="overflow: scroll;">
                                        <?php 

                                    $get_users = $bdd->prepare('SELECT * FROM GIVE_TOOL,OMT_USER WHERE OMT_USER.id_user = GIVE_TOOL.id_user LIMIT 15');
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
                                        <button class="btn btn-link text-secondary" onclick="set_id_modal('.$donnees['id_user'].')" data-bs-toggle="modal" data-bs-target="#send_mail_modal"><i class="fa-solid fa-envelope"></i></button>
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
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- Modal -->
            <div class="modal fade" id="send_mail_modal" tabindex="-1" aria-labelledby="send_mail_modal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="send_mail_modal_title">Envoyer un mail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="send_mail_modal-content">
                            <h4>Envoyer un mail un utilisateur</h4>
                            <hr>
                            <div class="form-group">
                                <div id="hidden"></div>
                                <div id="mail_msg_box"></div>
                                <select id="mail_file" class="form-select">
                                    <?php
                                    //read all file from the folder
                                    $files = scandir('../../assets/mails/');
                                    foreach($files as $file){
                                        if($file != '.' && $file != '..'){
                                            echo '<option value="'.$file.'">'.explode(".",$file)[0].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group mt-3 float-end">
                                <button class="btn btn-primary" onclick="sendmail()">
                                    Envoyer
                                </button>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <?php 
                include('../../includes/include-footer.php');
            ?>
            <?php 
                include('../../includes/include-script.php');
            ?>
            <script src="/dashboard/assets/js/dashboard_script.js"></script>
            <script src="js/userlogs.js"></script>
        </div>
    </div>
</body>

</html>