<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');
    
    $actual_page = "admin/training.php";

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
                        <li class="breadcrumb-item active">Programme Sportif</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="fa-solid fa-dumbbell"></i>
                            Listes des Programmes

                            <button class="btn btn-link text-dark float-end" onclick="create_training()"><i
                                    class="fa-solid fa-plus"></i>
                                </button>
                        </div>
                        <div class="card-body">
                            <div id="training_list_msg_box">

                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>Id</th>
                                            <th>Nom</th>
                                            <th>Confidencialité</th>
                                            <th>Créer par</th>
                                            <th>Date de création</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="training_list">
                                    <?php 

                                    $get_training = $bdd->prepare('SELECT id_training,name_training,privacy_training,creation_date,firstname,surname,TRAINING.id_user FROM TRAINING,OMT_USER WHERE TRAINING.id_user = OMT_USER.id_user ORDER BY creation_date DESC');
                                    $get_training->execute();

                                    while($donnees = $get_training->fetch()){
                                        echo '<tr class="text-center align-middle">';
                                        echo '<td>'.$donnees['id_training'].'</td>';
                                        echo '<td class="name_training" value="'.$donnees['id_training'].'">'.$donnees['name_training'].'</td>';
                                        echo '<td>'.get_training_privacy($donnees['privacy_training']).'</td>';
                                        echo '<td>'.$donnees['firstname'].'<small class="text-muted"> #</small><small class="text-muted" name="id_user">'.$donnees['id_user'].'</small></td>';
                                        echo '<td>'.$donnees['creation_date'].'</td>';
                                        echo '<td>
                                        <a href="edit_training.php?id='.$donnees['id_training'].'" class="btn btn-link text-dark" onclick="get_training_detail(\''.$donnees['id_training'].'\',\''.$donnees['name_training'].'\')"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <button class="btn btn-link text-danger" onclick="delete_training('.$donnees['id_training'].')"><i class="fa-solid fa-trash-can"></i></button></td>';
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

            <?php 
                include('../../includes/include-footer.php');
            ?>
            <?php 
                include('../../includes/include-script.php');
            ?>
            <script src="/dashboard/assets/js/dashboard_script.js" class="noreload"></script>
            <div id="scripttoreload">
                <script src="js/training.js"></script>
            </div>

        </div>
    </div>
</body>

</html>