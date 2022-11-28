<?php
//Copyright (c) 2022 Victor STEC

    include('../../includes/include-bdd.php');

    $actual_page = "admin/coupons.php";

    include('../../includes/include-session-check.php');
    
    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    if($user_info['permissions_level'] != 1){
        header('Location: ../../index.php');
    }

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
                    <li class="breadcrumb-item">Boutique</li>
                </ol>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fa-solid fa-barcode"></i>
                                Liste des codes
                            </div>
                            <div class="card-body">
                                <div id="product_table_msg_box">

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th scope="col">Id</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Valeur</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="coupon_list">
                                            <?php 
                                             $req_product = $bdd->prepare("SELECT * FROM COUPON");
                                             $req_product->execute();
                                             $product_info = $req_product->fetchAll();
                                                    for ($i=0; $i < count($product_info) ; $i++) { 
                                                        echo '<tr id="Line'.$product_info[$i]['coupon_id'].'" class="text-center align-middle">';
                                                        echo '<td>'.$product_info[$i]['coupon_id'].'</td>';
                                                        echo '<td>'.$product_info[$i]['code'].'</td>';
                                                        echo '<td>'.$product_info[$i]['coupon_value'].' %</td>';
                                                        echo '<td>'.$product_info[$i]['exp_date'].'</td>';
                                                        echo '<td>
                                                        <button onclick="delete_coupon('.$product_info[$i]['coupon_id'].')" class="btn btn-link text-danger"><i class="fa-solid fa-ban"></i></button>
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
                            <div class="card-header">
                            <i class="fa-solid fa-barcode"></i>
                                Ajouter des Codes
                            </div>

                            <div class="card-body">
                                
                                <form id="coupon-add" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="code"
                                                    placeholder="Nom du produit" id="code" required>
                                                <label for="code">Code</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="coupon_value"
                                                    placeholder="Valeur en pourcentage" id="coupon_value" required>
                                                <label for="coupon_value">Valeur (%)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                        <label for="exp_date">Date d'expiration</label>
                                            <div class="form-floating mb-3">
                                                <input type="date" class="form-control" name="exp_date"
                                                     id="exp_date" required>
                                                
                                            </div>
                                        </div>
        
                                        <button type="submit disabled" class="btn btn-primary">Ajouter</button>
                                    </div>
                                </form>
                            </div>
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
       
        <script src="js/coupon.js"></script>
    </div>
</body>

</html>