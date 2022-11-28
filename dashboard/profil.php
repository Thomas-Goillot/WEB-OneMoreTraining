<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    
    $actual_page = "profil.php";

    include('../includes/include-session-check.php');
    
    include('../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    include('../includes/include-info.php');

    include('../includes/include-head.php');
?>

<body class="sb-nav-fixed">
    <?php 
        include('includes/include-nav-dashboard.php');
    ?>

    <div id="layoutSidenav">
        <?php 
        include('includes/include-sidenav-dashboard.php');
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Votre Profil</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Informations Utilisateurs</li>
                    </ol>
                    <?php 
                    if(isset($_GET['val'])){
                        echo '<div class="alert alert-success" role="alert">
                                Votre compte a bien été validé !
                            </div>';
                    }

/*                     if(empty($user_info['firstname']) || empty($user_info['surname']) || empty($user_info['mail']) || empty($user_info['date_of_birth']) || empty($user_info['phone_number']) || empty($user_info['gender']) || empty($user_info['height']) || empty($user_info['weight'])){
                        echo '<div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Vous n\'avez pas complété toutes vos informations !</h4>
                            <p>Veuillez compléter toutes vos informations pour pouvoir accéder à toutes les fonctionnalités de l\'application.</p>
                            <hr>
                            <p class="mb-0">
                                <a href="profil.php" class="btn btn-primary">Compléter mes informations</a>
                            </p>
                        </div>';
                    } */

                    if($user_info['mail_verified'] != 1){
                        echo '<div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Vous n\'avez pas validé votre adresse mail !</h4>
                            <p>Veuillez valider votre adresse mail pour pouvoir accéder à toutes les fonctionnalités de l\'application.</p>
                            <hr>
                            <p class="mb-0">
                                <div id="mail_check_msg_box"></div>
                                <button onclick="sendmail('.$user_info['id_user'].',\'confirm_mail.php\')" class="btn btn-primary">Renvoyer l\'email</button>
                            </p>
                        </div>';
                    }
                    
                    ?>
                    <div class="row">

                        <div class="col-xl-3 col-md-3 d-flex align-items-stretch">
                            <div class="card bg-light text-white mb-4">
                                <div class="card-body">
                                    <?= load_avatar($bdd,$_SESSION['id_user']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-9 col-md-9 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <h1><?= $user_info['firstname'].' '.$user_info['surname'].' <small class="text-muted">#'.$user_info['id_user'].'</small>' ?>
                                    </h1>
                                    <p><small class="text-muted">
                                        <?php 
                                        $req_subscribe = $bdd->prepare('SELECT subscribe_name FROM SUBSCRIBE WHERE id_subscribe = (SELECT id_subscribe FROM GIVE_TOOL WHERE id_user = ?)');
                                        $req_subscribe->execute(array($_SESSION['id_user']));
                                        $subscribe = $req_subscribe->fetch();

                                        $req_date = $bdd->prepare('SELECT date_of_delivery FROM GIVE_TOOL WHERE id_user = ?');
                                        $req_date->execute(array($_SESSION['id_user']));
                                        $date = $req_date->fetch();

                                        if(isset($date['date_of_delivery'])){
                                            $date_of_delivery = date('Y-m-d', strtotime($date['date_of_delivery'].' + 1 year'));
                                            echo 'Abonnement <strong>'.$subscribe['subscribe_name'].'</strong> jusqu\'au '.literalDate($date_of_delivery);
                                        }
                                        else{
                                            echo 'Abonnement <strong>OMT Gratuit</strong>';
                                        }
                                        ?>
                                    </small>
                                    <a class="text-info float-end" href="/ajax/get_user_information_file.php?id_user=<?=$_SESSION['id_user']?>"><i class="fa-solid fa-download"></i></a>
                                    </p>
                                    <hr>
                                    <p><?= $user_info['description']?></p>

                                    <a href="add_signature.php" class="btn btn-success"> Ajouter votre signature </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-md-12 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-header">Information</h5>
                                        <h6 class="muted-text d-flex align-items-center"><?= get_gender($user_info['gender']) ?></h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="info">
                                            <p class="mb-0"><b>Taille: </b><?= $user_info['height'] ?></p>
                                        </div>
                                        <div class="info">
                                            <p class="mb-0"><b>Poids: </b><?= $user_info['weight'] ?></p>
                                        </div>
                                        <div class="info">
                                            <p class="mb-0"><b>IMC: </b>
                                                <?= $user_info['weight'] != 0 ? ($user_info['height'] != 0 ? ($user_info['weight'] / ( $user_info['height'] * 0.01)^2) : 0) : 0  ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-12 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-header">Vos Badges</h5>
                                        <a href="#">
                                            <h6 class="muted-text d-flex align-items-center">Tout voir</h6>
                                        </a>
                                    </div>
                                    <?php 

                                        $req_id_user_badge = $bdd->prepare("SELECT img_badge,nb_seance_user_required FROM COLLECTED_BADGE,BADGE WHERE id_user = ? AND COLLECTED_BADGE.id_badge = BADGE.id_badge");
                                        $req_id_user_badge->execute(array($_SESSION['id_user']));
                                        $req_id_user_badge_info = $req_id_user_badge->fetchAll();
                                        
                                        for ($y=0; $y < count($req_id_user_badge_info) ; $y++) 
                                        { 
                                            echo get_badge($req_id_user_badge_info[$y]['nb_seance_user_required'],$req_id_user_badge_info[$y]['img_badge']);
                                        } 

                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-12 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-header">Vos Objectifs</h5>
                                        <a href="objective.php">
                                            <h6 class="muted-text d-flex align-items-center">Tout voir</h6>
                                        </a>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                    <?php 

                                        $req_objective = $bdd->prepare("SELECT name FROM OBJECTIVE WHERE id_user = ? LIMIT 2");
                                        $req_objective->execute(array($_SESSION['id_user']));
                                        $req_objective_info =  $req_objective->fetchAll();
                                        
                                        for ($y=0; $y < count( $req_objective_info) ; $y++) 
                                        { 
                                            echo '<li class="list-group-item d-flex align-items-center">
                                            <p class="me-auto mb-0">'.$req_objective_info[$y]['name'].'</p>
                                            <a href="#" class="ms-auto link-dark"><i class="fa-solid fa-eye justify-self-end"></i></a>
                                            </li>';
                                        } 

                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-md-12 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-header">Historique de séance</h5>
                                        <a href="#">
                                            <h6 class="muted-text d-flex align-items-center">Tout voir</h6>
                                        </a>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php 

                                        $get_users_training_historical = $bdd->prepare('SELECT training_duration,training_date,name_training FROM TRAINING_HISTORICAL,TRAINING WHERE TRAINING_HISTORICAL.id_user = ? AND TRAINING_HISTORICAL.id_training = TRAINING.id_training ORDER BY training_date DESC LIMIT 3');
                                        $get_users_training_historical->execute(array($_SESSION['id_user']));
                                        $get_users_training_historical_info = $get_users_training_historical->fetchAll();
                                        
                                        for ($y=0; $y < count($get_users_training_historical_info) ; $y++) 
                                        { 
                                            echo '<li class="list-group-item d-flex align-items-center">
                                            <p class="me-auto mb-0">'.$get_users_training_historical_info[$y]['name_training'].'</p>
                                            <p class="mb-0">'.$get_users_training_historical_info[$y]['training_date'].'</p>
                                            <a href="#" class="ms-auto link-dark"><i class="fa-solid fa-eye justify-self-end"></i></a>
                                            </li>';
                                        } 

                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-12 d-flex align-items-stretch">
                            <div class="card bg-light mb-4 w-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h5 class="card-header">Vos Groupes</h5>
                                        <a href="group_user.php">
                                            <h6 class="muted-text d-flex align-items-center">Tout voir</h6>
                                        </a>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php 

                                        $get_users_group = $bdd->prepare('SELECT group_name FROM GROUP_INFO,GROUP_RELATIONSHIP WHERE GROUP_INFO.id_group = GROUP_RELATIONSHIP.id_group AND id_user = ? AND GROUP_RELATIONSHIP.group_status = 1 LIMIT 2');
                                        $get_users_group->execute(array($_SESSION['id_user']));
                                        $get_users_group_info =  $get_users_group->fetchAll();
                                        
                                        for ($y=0; $y < count( $get_users_group_info) ; $y++) 
                                        { 
                                            echo '<li class="list-group-item d-flex align-items-center">
                                            <p class="me-auto mb-0">'. $get_users_group_info[$y]['group_name'].'</p>
                                            <a href="#" class="ms-auto link-dark"><i class="fa-solid fa-eye justify-self-end"></i></a>
                                            </li>';
                                        } 

                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </main>
            <?php 
                include('../includes/include-footer.php');
            ?>
            <?php 
                include('../includes/include-script.php');
            ?>
            <script src="/dashboard/assets/js/dashboard_script.js"></script>
            <script src="/dashboard/assets/js/profil.js"></script>
        </div>
    </div>
</body>

</html>