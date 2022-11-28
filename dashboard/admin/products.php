<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');

    $actual_page = "admin/products.php";

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

        <main id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard OMT</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Informations principales</li>
                </ol>
                <div class="row" id="product_header">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <h5>Produits disponible à la vente:</h5>

                                <?php 

                                    $req_product_available = $bdd->prepare("SELECT * FROM PRODUCT WHERE quantity > 0");
                                    $req_product_available->execute();
                                    $product_info = $req_product_available->rowCount();

                                    echo "<h1 class='text-align'>$product_info <i class='fa-solid fa-eye'></i></h1>";
                                    ?>
                            </div>

                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">Voir en détails</a>
                                <div class="small text-white"><i class="bi bi-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <h5>Produits indisponible à la vente:</h5>

                                <?php 
                                    $req_product_unavailable = $bdd->prepare("SELECT * FROM PRODUCT WHERE quantity <= 0");
                                    $req_product_unavailable->execute();
                                    $req_product_unavailable_number = $req_product_unavailable->rowCount();
                                    echo "<h1 class='text-align'> $req_product_unavailable_number</h1>";
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
                </div>

                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Boutique</li>
                </ol>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Listes des produits
                            </div>
                            <div class="card-body">
                                <div id="product_table_msg_box">

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th scope="col">Id</th>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Prix</th>
                                                <th scope="col">Quantité</th>
                                                <th scope="col">Date d'ajout</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product_list">
                                            <?php 
                                             $req_product = $bdd->prepare("SELECT * FROM PRODUCT");
                                             $req_product->execute();
                                             $product_info = $req_product->fetchAll();
                                                    for ($i=0; $i < count($product_info) ; $i++) { 
                                                        echo '<tr class="text-center align-middle">';
                                                        echo '<td>'.$product_info[$i]['id_product'].'</td>';
                                                        echo '<td>'.$product_info[$i]['name'].'</td>';
                                                        echo '<td>'.$product_info[$i]['price'].' €</td>';
                                                        echo '<td>'.$product_info[$i]['quantity'].'</td>';
                                                        echo '<td>'.explode(" ",$product_info[$i]['added_date'])[0].'</td>';
                                                        echo '<td>
                                                        <button type="button" onclick="get_id_product('.$product_info[$i]['id_product'].')" data-bs-toggle="modal" data-bs-target="#modify_product" class="btn btn-link text-primary"><i class="fa-solid fa-eraser"></i></button>                          
                                                        <button onclick="delete_product('.$product_info[$i]['id_product'].')" class="btn btn-link text-danger"><i class="fa-solid fa-ban"></i></button>
                                                        <button class="btn btn-link text-warning"><i class="fa-solid fa-eye"></i></button>
                                                        </td>';
                                                        echo '<tr>';
                                                    }                                   
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Ajouter des Produits
                            </div>

                            <div class="card-body">
                                <div id="add_product_msg_box">

                                </div>
                                <form id="product-add" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="name_product"
                                                    placeholder="Nom du produit" id="name_product" required>
                                                <label for="name_product">Nom</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="price_product"
                                                    placeholder="Prix du produit" id="price_product" required>
                                                <label for="price_product">Prix</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="quantity_product"
                                                    placeholder="Quantiter" id="quantity_product" required>
                                                <label for="quantity_product">Quantité</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control form-control-lg mb-3"
                                                id="image_product" name="image_product" accept="image/jpeg,image/png"
                                                required>
                                        </div>

                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Description du profil"
                                            id="description_product" style="height: 100px"
                                            name="description_product"></textarea>
                                        <label for="description_product">Description du produit</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modify_product" tabindex="-1" aria-labelledby="modify_product_label"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modify_product_label">Modifier le produit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modify_product-content">

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
        <script src="js/product.js"></script>
    </div>
</body>

</html>