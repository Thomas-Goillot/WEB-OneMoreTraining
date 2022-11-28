<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');

    $actual_page = "sales_user.php";

    include('../includes/include-session-check.php');

    include('../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
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

        <main id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Vos Commandes</h1>                

                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">& le détail</li>
                </ol>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-title text-dark">
                                <i class="fa-solid fa-basket-shopping"></i>
                                Listes de vos commandes
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th scope="col">Numéro de commande</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Prix Total</th>
                                                <th scope="col">Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sales_list">
                                            <?php 
                                                    $req_sales_all = $bdd->prepare("SELECT * FROM USER_COMMAND WHERE id_user = ? ORDER BY date_of_purchase DESC");
                                                    $req_sales_all->execute(array($_SESSION['id_user']));
                                                    $sales_info = $req_sales_all->fetchAll();
                                                    for ($i=0; $i < count($sales_info) ; $i++) { 
                                                        echo '<tr class="text-center align-middle">';
                                                        echo '<td>'.$sales_info[$i]['id_command'].'</td>';
                                                        echo '<td>'.$sales_info[$i]['date_of_purchase'].'</td>';
                                                        echo '<td>'.$sales_info[$i]['total_price'].' €</td>';
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
                include('../includes/include-footer.php');
            ?>
        </main>
        <?php 
                include('../includes/include-script.php');
            ?>
        <script src="/dashboard/assets/js/dashboard_script.js"></script>
        <script src="/dashboard/assets/js/sales_user.js"></script>
    </div>
</body>

</html>