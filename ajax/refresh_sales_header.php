<?php /*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    $req_product = $bdd->prepare("SELECT * FROM PRODUCT");
    $req_product->execute();
    $product_info = $req_product->fetchAll();
?>
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">
            <h5>Nombre de vente aujourd'hui:</h5>

            <?php 
                $req_sales = $bdd->prepare("SELECT date_of_purchase FROM USER_COMMAND WHERE DATE(date_of_purchase) = ?");
                $req_sales->execute(array(date('Y-m-d')));
                $req_sales_today = $req_sales->rowCount();
                echo "<h1 class='text-align'>$req_sales_today</h1>";
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
            <h5>Nombre de vente ce mois-ci:</h5>

            <?php 
                $req_sales = $bdd->prepare("SELECT date_of_purchase FROM USER_COMMAND WHERE MONTH(date_of_purchase) = ?");
                $req_sales->execute(array(date('m')));
                $req_sales_month = $req_sales->rowCount();
                echo "<h1 class='text-align'>$req_sales_month</h1>";
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
            <h5>Nombre de vente total:</h5>

            <?php 
                $req_sales = $bdd->prepare("SELECT date_of_purchase FROM USER_COMMAND");
                $req_sales->execute();
                $req_sales_all = $req_sales->rowCount();
                echo "<h1 class='text-align'>$req_sales_all</h1>";
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
            <h5>Produits disponible à la vente:</h5>

            <?php 
            $req_product = $bdd->prepare("SELECT * FROM PRODUCT");
            $req_product->execute();
            $product_info = $req_product->fetchAll();
            $product_number = count($product_info);
            echo "<h1 class='text-align'>$product_number <i class='fa-solid fa-eye'></i></h1>";
            ?>
        </div>

        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">Voir en détails</a>
            <div class="small text-white"><i class="bi bi-angle-right"></i></div>
        </div>
    </div>
</div>
