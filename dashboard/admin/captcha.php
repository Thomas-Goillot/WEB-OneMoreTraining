<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');

    $actual_page = "admin/captcha.php";

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
                    <li class="breadcrumb-item active">Captcha</li>
                </ol>
                <div class="row align-middle">
                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Captcha Test Working
                            </div>
                            <div class="card-body">

                                <?php 
                                    include('../../includes/include-captcha.php');
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-cart-shopping"></i>
                                Ajouter des images
                            </div>

                            <div class="card-body">
                                <div id="add_captcha_msg_box">

                                </div>
                                <form id="captcha-img-add" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="file" class="form-control form-control-lg mb-3"
                                                id="image_captcha" name="image_captcha" accept="image/jpeg,image/png"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="submit"
                                                class="btn btn-primary container-fluid">Ajouter</button>
                                        </div>
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
        <script src="/dashboard/assets/js/dashboard_script.js"></script>
        <script src="js/captcha_add_img.js"></script>
        <script src="/assets/js/captcha.js"></script>
    </div>
</body>

</html>