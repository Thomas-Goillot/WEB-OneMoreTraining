<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    session_start();
    if(isset($_SESSION)){
        if(@$_SESSION['last_activity'] > time()- @$_SESSION['expire_time'] ) { // EXPIRATION ? //
            header('Location: /main.php');
            exit;
        }
    }

    $actual_page = "index.php"; 

    include('includes/include-bdd.php');

    /* $add_user_log = $bdd->prepare('INSERT INTO USER_LOG (activity,id_user) VALUES (?,?)');
    $add_user_log->execute(array($actual_page,-1));  */

    include('includes/include-info.php');

    include('includes/include-head.php');

    include('includes/include-functions.php');

?>

<script>
//scroll detection
window.onscroll = function() {
    scrolldetection()
};
</script>

<body>
<header>
    <div class="container-fluid">
        <nav
            class="navbar p-3 navbar-color navbar-expand-lg fixed-top d-flex flex-wrap align-items-center justify-content-lg-center">
            <a href="/"
                class="d-flex align-items-center justify-content-lg-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <img src="assets/img/logo_black.png" width="80" height="50" role="img" class="logo-img bi me-2">
            </a>
            <span class="vertical bd-light d-none d-lg-block"></span>

            <button class="navbar-toggler navbar-light border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-dark">Accueil</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Entrainements</a></li>
                    <li><a href="#" class="nav-link px-2 link-dark">Boutique</a></li>
                </ul>

                <a href="login.php" class="nav-link px-2 link-dark">Connexion</a>
                <a href="register.php" class="nav-link px-2 link-dark">Inscription</a>

            </div>
        </nav>
    </div>
</header>
    <main>

        <section class="banner">
            <div class="inner">
                <div class="content">
                    <h1 class="text-center">One More Training</h1>
                    <h3 class="text-center">Commencez à vous entrainer dès maintenant</h3>
                </div>
            </div>
        </section>
        <div class="container">
            <hr class="mt-5 mb-5">
        </div>
        <section>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h2 class="">One More Training <span class="text-muted">À votre tour de faire du sport!</span></h2>
                        <p class="lead">Pourquoi le faites-vous ? Pour atteindre votre objectif ? Pour passer un bon moment entre amis ? Quelle que soit votre raison, le fitness est essentiel. 
                            <br><br>
                            Qu'il s'agisse d'une séance cardio, en groupe ou seul, que vous soyez débutant ou confirmé. Qui que vous soyez, quel que soit votre niveau, nous sommes gratuit et ouvert à tous ! Go For It
                        </p>
                    </div>
                    <div class="col-md-5">
                        <img class="img-fluid mx-auto rounded" data-src="/assets/img/tropbien.jpg"
                            alt="image of a two sportifs" src="assets/img/tropbien.jpg" data-holder-rendered="true">
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <hr class="mt-5 mb-5">
        </div>
        <section>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <img class="img-fluid mx-auto rounded" data-src="/assets/img/tropbien.jpg"
                            alt="image of a two sportifs" src="assets/img/tropbien.jpg" data-holder-rendered="true">
                    </div>
                    <div class="col-md-7">
                        <h2 class="">Pourquoi nous? <span class="text-muted">Parce que c'est trop bien</span></h2>
                        <p class="lead">S'inscrire chez nous est un bon premier pas. L'étape suivante consistera à trouver votre routine. C'est là que One More Training est prêt à vous aider. Car si vous êtes et restez motivé(e)s, vous êtes définitivement sur la voie du succès. Après une courte inscription en ligne, vous pouvez instantanément accéder aux séances gratuite proposé par OMT </p>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <hr class="mt-5 mb-5">
        </div>
        <section>
            <div class="container mt-5">
                <div class="row">
                <?php
                echo pwd_hash("test");
                    $req_subscribe = $bdd->prepare("SELECT * FROM SUBSCRIBE");
                    $req_subscribe->execute();
                    $req_subscribe_info =  $req_subscribe->fetchAll();
                    for ($y=0; $y < count( $req_subscribe_info) ; $y++) 
                    { 
                        echo '
                        <div class="col-sm-4 d-flex align-items-stretch">
                        <div class="card mb-4 shadow-sm bg-light">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal text-center">'.$req_subscribe_info[$y]['subscribe_name'].'</h4>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h1 class="card-title pricing-card-title text-center">'.$req_subscribe_info[$y]['subscribe_price'].'€ <small class="text-muted">/
                                        mois</small>
                                </h1>
                                <ul class="list-unstyled mt-3 mb-5">';

                                if($req_subscribe_info[$y]['id_subscribe_inheritance'] != NULL OR $req_subscribe_info[$y]['id_subscribe_inheritance'] != 0){
                                    $req_subscribe_inheritance = $bdd->prepare("SELECT subscribe_name FROM SUBSCRIBE WHERE id_subscribe = ?");
                                    $req_subscribe_inheritance->execute(array($req_subscribe_info[$y]['id_subscribe_inheritance']));
                                    $req_subscribe_inheritance_info =  $req_subscribe_inheritance->fetch();
                                    echo '
                                    <li><small class="text-muted">
                                    <i class="bi bi-check2 text-success"></i>
                                    Inclus '.$req_subscribe_inheritance_info['subscribe_name'].'</small>
                                    </li>';
                                }

                                foreach (explode('-', $req_subscribe_info[$y]['subscribe_description']) as $key => $value) {
                                    echo '<li>'.$value.'</li>';
                                }

                                echo '</ul>
                                <div class="text-center mt-auto">
                                    <a href="connexion.php?err=Vous devez créer un compte avant de pouvoir continuer"
                                        class="btn btn-lg btn-block btn-outline-primary mt-auto align-self-start">J\'en
                                        profite</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';

                    }
                    ?>
                </div>
            </div>

        </section>

    </main>
    <?php 
        include('includes/include-footer.php');
    ?>
    <?php 
        include('includes/include-script.php');
    ?>
</body>

</html>