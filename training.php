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

    $id_training = $_GET['id_training'];

    $sql = "SELECT * FROM TRAINING WHERE id_training = :id_training";
    $query = $bdd->prepare($sql);
    $query->bindParam(':id_training', $id_training);
    $query->execute();
    $training_info = $query->fetch();

    if(!isset($training_info['id_training'])){
        header('Location: main.php');
    }

/*     if($training_info['id_user'] != $_SESSION['id_user'] || $training_info['privacy_training'] != 1){
        header('Location: main.php');
    } */
?>
<body onload="init(<?=$id_training?>)">
    <?php 
        include('includes/include-header.php');
    ?>
    <main class="mb-5" style="padding-top: 8rem">
        <section>
            <div class="container">
                <h1 class="text-center"><?= $training_info['name_training'] ?></h1>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body" id="content">
                                Chargement en cours...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <script src="/assets/js/training.js"></script>
    <?php 
        include('includes/include-footer.php');
    ?>
    <?php 
        include('includes/include-script.php');
    ?>
</body>

</html>