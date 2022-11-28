<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');
    
    $actual_page = "group_edit.php";

    include('../../includes/include-session-check.php');
    
    include('../../includes/include-functions.php');

    $id_group = $_GET['id'];

    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    //SI pas training de l'utilisateur redirigé vers list programme
    $req_id_training = $bdd->prepare('SELECT COUNT(id_group) AS id FROM GROUP_RELATIONSHIP WHERE id_group = ? AND id_user = ?');
    $req_id_training->execute(array($id_group,$_SESSION['id_user']));
    $req_id_training_info = $req_id_training->fetch(); 

    if($user_info['permissions_level'] != 1){
        header('Location: ../../index.php');
    }


    //information du group a partir de l'id
    $req_group_info = $bdd->prepare('SELECT * FROM GROUP_INFO WHERE id_group = ?');
    $req_group_info->execute(array($id_group));
    $group_info = $req_group_info->fetch();


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
                    <h1 class="mt-4"><?= $group_info['group_name']?></h1>

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><a href="group_user.php">Listes des Groupes</a> <span
                                class="text-muted">/</span> <?= $group_info['group_name']?> </li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="fa-solid fa-dumbbell"></i>
                            Utilisateurs du groupe <?= $group_info['group_name']?>

                            <button class="btn btn-link text-dark float-end" data-bs-toggle="modal" data-bs-target="#add_user" ><i
                                    class="fa-solid fa-plus"></i>
                                </button>
                        </div>
                        <div class="card-body">
                            <div id="group_detail_msg_box">

                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Permission</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="group_detail_list">
                                        <?php 
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <!-- Modal user info-->
            <div class="modal fade" id="get_user_group_info" tabindex="-1" aria-labelledby="get_user_group_info" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="get_user_group_info_title">Détails de l'utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="get_user_group_info_content">
                            <h3>Chargement des informations utilisateurs...</h3>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Modal add_user-->
            <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="add_user" aria-hidden="true" >
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="add_user_title">Détails de l'utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Chercher un utilisateur</label>
                            <input type="text" class="form-control" id="search-user_group" onkeyup="search_user_group(<?= $_GET['id']?>)" placeholder="Chercher un utilisateur">
                        </div>
                        <hr>

                                
                            <div id="add_user_content">
                                <?php
                                $get_users = $bdd->prepare('SELECT id_user,firstname,surname,banned FROM OMT_USER WHERE id_user NOT IN (SELECT id_user FROM GROUP_RELATIONSHIP WHERE id_group = ?) ORDER BY id_user LIMIT 10 ');
                                $get_users->execute(array($id_group));

                                echo '
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>#</th>
                                            <th>Prénom</th>
                                            <th>Nom</th>
                                            <th>Ban Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    ';
                                while($donnees = $get_users->fetch()){
                                    echo '<tr class="text-center align-middle">';
                                    echo '<td>'.$donnees['id_user'].'</td>';
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
            <script src="/dashboard/assets/js/dashboard_script.js" class="noreload"></script>
            <div id="scripttoreload">
                <script src="/dashboard/admin/js/group_edit.js"></script>
            </div>

        </div>
    </div>
</body>

</html>