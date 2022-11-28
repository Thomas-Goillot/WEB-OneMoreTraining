<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../../includes/include-bdd.php');
    
    $actual_page = "admin/subscribe_edit.php";

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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard OMT</h1>
                                       
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Abonnements</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="bi bi-table"></i>
                            Listes des Forfaits
                        </div>
                        <div class="card-body">
                            <div id="group_list_msg_box">

                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>Id</th>
                                            <th>Nom</th>
                                            <th>Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody id="group_list">
                                        <?php 

                                        $req_subscribe = $bdd->prepare("SELECT * FROM SUBSCRIBE");
                                        $req_subscribe->execute();
                                        $req_subscribe_info =  $req_subscribe->fetchAll();
                                        for ($y=0; $y < count( $req_subscribe_info) ; $y++) 
                                        { 
                                        echo '<tr class="text-center align-middle">';
                                        echo '<td>'.$req_subscribe_info[$y]['id_subscribe'].'</td>';
                                        echo '<td value="'.$req_subscribe_info[$y]['id_subscribe'].'" name="subscribe_name">'.$req_subscribe_info[$y]['subscribe_name'].'</td>';
                                        echo '<td value="'.$req_subscribe_info[$y]['id_subscribe'].'" name="subscribe_price">'.$req_subscribe_info[$y]['subscribe_price'].'</td>';
                                        echo '</tr>';
                                    }                                     
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php 
        include('../../includes/include-footer.php');
        include('../../includes/include-script.php');
    ?>
        <script src="/dashboard/assets/js/dashboard_script.js" class="noreload"></script>
        <div id="scripttoreload">                
            <script src="js/subscribe_edit.js"></script>
        </div>
    </div>
    </div>
</body>

</html>