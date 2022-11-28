<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');

    $actual_page = "admin/sales.php";

    include('../../includes/include-session-check.php');

    include('../../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    if($user_info['permissions_level'] != 1){
        header('Location: ../index.php');
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

        <main id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard OMT</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Informations principales</li>
                </ol>
                <div class="row" id="sales_header">
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
                </div>

                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Ventes</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Listes des ventes
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th scope="col">Id</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Prix Total</th>
                                                <th scope="col">Id utilisateur</th>
                                                <th scope="col">Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sales_list">
                                            <?php 
                                                    $req_sales_all = $bdd->prepare("SELECT * FROM USER_COMMAND ORDER BY date_of_purchase DESC");
                                                    $req_sales_all->execute();
                                                    $sales_info = $req_sales_all->fetchAll();
                                                    for ($i=0; $i < count($sales_info) ; $i++) { 
                                                        echo '<tr class="text-center align-middle">';
                                                        echo '<td>'.$sales_info[$i]['id_command'].'</td>';
                                                        echo '<td>'.$sales_info[$i]['date_of_purchase'].'</td>';
                                                        echo '<td>'.$sales_info[$i]['total_price'].' €</td>';
                                                        echo '<td>'.$sales_info[$i]['id_user'].'</td>';
                                                        echo '<td><button class="btn btn-link text-warning" onclick="get_command_detail('.$sales_info[$i]['id_command'].')" data-bs-toggle="modal" data-bs-target="#see_command_detail"><i class="fa-solid fa-eye"></i></button></td>';
                                                        echo '<tr>';
                                                    }                                   
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="see_command_detail" tabindex="-1" aria-labelledby="see_command_detail_label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="see_command_detail_label">Contenu de la commande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="command-detail-content">

                        </div>
                    </div>
                </div>
            </div>

            <?php 
                include('../../includes/include-footer.php');
            ?>
        </main>
        <?php 
                include('../../includes/include-script.php');
            ?>
        <script src="/dashboard/assets/js/dashboard_script.js"></script>
        <script src="js/sales.js"></script>
    </div>
</body>

</html>