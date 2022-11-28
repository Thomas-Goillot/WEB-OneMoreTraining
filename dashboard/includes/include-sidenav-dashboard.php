<?php 
/*
* Created on Mon Apr 04 2022
*
* Copyright (c) 2022 Thomas GOILLOT
*/

/* if(!isset($bdd)){
    session_start();
    include('../../includes/include-bdd.php');
    $get_user = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
    $get_user->execute(array($_SESSION['id_user']));
    $user_info = $get_user->fetch();
} */
    echo '
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-lock"></i> Utilisateur</div>

                    <a class="nav-link" href="/">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-house"></i></div>
                        Accueil
                    </a>

                    <a class="nav-link" href="/dashboard/profil.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        Profil
                    </a>

                    <a class="nav-link" href="/avatar.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-astronaut"></i></div>
                        Votre Avatar
                    </a>

                    <a class="nav-link" href="/dashboard/training_user.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-list"></i></div>
                        Vos Programmes
                    </a>

                    <a class="nav-link" href="/dashboard/">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-hand-back-fist"></i></div>
                        Vos Amis
                    </a>

                    <a class="nav-link" href="/dashboard/group_user.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        <div class="padding-right">Vos Groupes</div>';
                        $get_notif = $bdd->prepare('SELECT COUNT(group_status) as notif FROM GROUP_RELATIONSHIP WHERE id_user = ? AND group_status = 2');
                        $get_notif->execute(array($_SESSION['id_user']));
                        $notif = $get_notif->fetch();
                        
                        if($notif['notif'] > 0){
                            echo '<button class="btn btn-info">'.$notif['notif'].'</button>';
                        }  
                        
                    echo '</a>

                    <a class="nav-link" href="/dashboard/objective.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-bullseye"></i></div>
                        Vos Objectifs
                    </a>

                    <a class="nav-link" href="/dashboard/sales_user.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                        Vos Commandes
                    </a>

                    <a class="nav-link" href="/dashboard/">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar"></i></div>
                        Evénements
                    </a>
                ';


                    switch ($user_info['permissions_level']) {
                        case 1:
                        echo '

                        <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-lock"></i> Administrateur</div>

                        <a class="nav-link" href="/dashboard/admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Utilisateurs
                        </a>

                        <a class="nav-link" href="/dashboard/admin/subscribe_edit.php">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-envelopes-bulk"></i></div>
                        Gestion Abonnements
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#boutiquedropdown" aria-expanded="false" aria-controls="boutiquedropdown">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                            Gestion Boutique
                            <div class="sb-sidenav-collapse-arrow"><i class="fa-solid fa-arrow-down"></i></div>
                        </a>
                        <div class="collapse" id="boutiquedropdown" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="/dashboard/admin/products.php">Gestion Produits</a>
                                <a class="nav-link" href="/dashboard/admin/sales.php">Gestion Ventes</a>
                                <a class="nav-link" href="/dashboard/admin/coupon.php">Gestion Codes Promo</a>
                            </nav>
                        </div>
                        
                        <a class="nav-link" href="/dashboard/admin/badge.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-certificate"></i></div>
                            Gestion badge
                        </a>

                        <a class="nav-link" href="/dashboard/admin/training.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-weight-hanging"></i></div>
                            Gestion Programme
                        </a>

                        <a class="nav-link" href="/dashboard/admin/group.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Gestion Groupe 
                        </a>

                        <a class="nav-link" href="/dashboard/admin/event.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar"></i></div>
                            Gestion Evénement 
                        </a>

                        <a class="nav-link" href="/dashboard/admin/captcha.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            Gestion Captcha 
                        </a>
                        ';
/*                         case 2:
                            echo '
                            <div class="sb-sidenav-menu-heading"><i class="fa-solid fa-graduation-cap"></i> OMT Ecole</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Groupes
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar"></i></div>
                                Evénements
                            </a>';
                        case 3:
                            echo '
                            <div class="sb-sidenav-menu-heading">OMT Premium</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Groupes
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar"></i></div>
                                Evénements
                            </a>'; */
                    }                   
                    ?>
<br><br>
                </div>
            </div>
        <div class="sb-sidenav-footer">
            <div class="small">Connecté en tant que:</div>
            <?= $user_info['firstname'] .' '. $user_info['surname'] .' <small class="text-muted">#'.$user_info['id_user'].'</small>' ?>
        </div>
    </nav>
</div>