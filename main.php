<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('includes/include-bdd.php');

    $actual_page = "main.php";    

    include('includes/include-session-check.php');

    include('includes/include-functions.php');

    include('includes/include-info.php');

    include('includes/include-head.php');
?>
<body>
    <?php 
        include('includes/include-header.php');
    ?>
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
                <h1 class="text-center">Nos entrainement les plus populaire en ce moment !</h1>
                <div class="row mt-5">
                    <?php 
                    $query = $bdd->prepare("SELECT TRAINING_HISTORICAL.id_training, count(TRAINING_HISTORICAL.id_training) nb
                    FROM TRAINING_HISTORICAL,TRAINING
                    WHERE TRAINING_HISTORICAL.id_training = TRAINING.id_training AND
                    TRAINING_HISTORICAL.id_training IS NOT NULL AND privacy_training = 1
                    GROUP BY TRAINING_HISTORICAL.id_training
                    ORDER BY count(TRAINING_HISTORICAL.id_training) DESC
                    LIMIT 3");
                    $query->execute();
                    $training_historical = $query->fetchAll();


                    foreach($training_historical as $training){
                        $sql = "SELECT * FROM TRAINING WHERE id_training = :id_training";
                        $query = $bdd->prepare($sql);
                        $query->bindParam(':id_training', $training['id_training']);
                        $query->execute();
                        $training_info = $query->fetch();
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-4 shadow-sm">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$training_info['name_training'].'</h5>';
                        echo '<p class="card-text">Plus de '.$training['nb'].' membres ont réalisé cet entrainement</p>';
                        echo '<div class="d-flex justify-content-between align-items-center">';
                        echo '<a href="training.php?id_training='.$training_info['id_training'].'" class="btn btn-lg btn-block btn-outline-primary mt-auto align-self-start ">Commencer</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </section>

        <div class="container">
            <hr class="mt-5 mb-5">
        </div>

        <section>
            <div class="container">
                <h1 class="text-center">Vos Objectifs !</h1>
                <div class="row mt-5">
                    <?php 
                    $req_objective = $bdd->prepare("SELECT name,description FROM OBJECTIVE WHERE id_user = ? LIMIT 3");
                    $req_objective->execute(array($_SESSION['id_user']));
                    $req_objective_info =  $req_objective->fetchAll();
                    for ($y=0; $y < count( $req_objective_info) ; $y++) 
                    { 
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-4 shadow-sm">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$req_objective_info[$y]['name'].'</h5>';
                        echo '<p class="card-text">'.$req_objective_info[$y]['description'].'</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
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
                    //req from SUBSCRIBE DB
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
                                    <a href="subscribe.php?id='.$req_subscribe_info[$y]['id_subscribe'].'"
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