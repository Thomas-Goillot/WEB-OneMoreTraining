<!--
--------------------------------------------------------
OMT © 2022
Thomas GOILLOT
-------------------------------------------------------- 
-->
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <h5>Nombre de visite total des utilisateurs aujourd'hui:</h5>
            <?php 
                include('../includes/include-bdd.php');
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