<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    
    $actual_page = "groupe.php";

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
    <div id="sidenav-reload">
        <?php 
        include('includes/include-sidenav-dashboard.php');
        ?>
            </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard OMT</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Crééer un groupe</li>
                    </ol>
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-title">
                                <i class="fa-solid fa-people-group"></i>
                                Création de Groupe
                            </div>

                            <div class="card-body">
                                <div id="add_group_msg_box">

                                </div>
                                <form id="group-add" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="name_group"
                                                    placeholder="Nom du Groupe" id="name_group" required>
                                                <label for="name_group">Nom du Groupe</label>
                                            </div>
                                        </div>
<!--                                         <div class="col-lg-6">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" name="id_admin_group"
                                                    placeholder="Id admin" id="id_admin_group" required>
                                                <label for="id_admin_group">Id admin</label>
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="id_admin_group" id="id_admin_group" value="<?=$_SESSION['id_user']?>">
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Description du profil"
                                            id="description_group" style="height: 100px"
                                            name="description_group"></textarea>
                                        <label for="description_group">Description du groupe</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Vos Groupes</li>
                    </ol>
                    
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="bi bi-table"></i>
                            Listes des Groupes
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
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="group_list">
                                    <?php 

                                    $get_group = $bdd->prepare('SELECT * FROM GROUP_INFO,GROUP_RELATIONSHIP WHERE GROUP_RELATIONSHIP.id_user = ? AND GROUP_INFO.id_group = GROUP_RELATIONSHIP.id_group AND GROUP_RELATIONSHIP.group_status = 2');
                                    $get_group->execute(array($_SESSION['id_user']));
                                    while($data = $get_group->fetch()){
                                        echo '<tr class="text-center align-middle table-info">';
                                        echo '<td>'.$data['id_group'].'</td>';
                                        echo '<td value="'.$data['id_group'].'" name="group_name">'.$data['group_name'].'</td>';
                                        echo '<td value="'.$data['id_group'].'" name="group_description">'.$data['group_description'].'</td>';
                                        echo '<td>
                                        <button class="btn btn-link text-success" onclick="join_group('.$data['id_group'].')"><i class="fa-solid fa-check"></i> Rejoindre </button>
                                        <button class="btn btn-link text-danger" onclick="decline_group('.$data['id_group'].')">Supprimer <i class="fa-solid fa-xmark"></i></button>
                                        </td>';
                                        echo '</tr>';
                                    }      

                                     

                                    $get_group = $bdd->prepare('SELECT * FROM GROUP_INFO,GROUP_RELATIONSHIP WHERE GROUP_RELATIONSHIP.id_user = ? AND GROUP_INFO.id_group = GROUP_RELATIONSHIP.id_group AND GROUP_RELATIONSHIP.group_status = 1');
                                    $get_group->execute(array($_SESSION['id_user']));
                                    while($data = $get_group->fetch()){
                                        echo '<tr class="text-center align-middle">';
                                        echo '<td>'.$data['id_group'].'</td>';
                                        echo '<td value="'.$data['id_group'].'" name="group_name">'.$data['group_name'].'</td>';
                                        echo '<td value="'.$data['id_group'].'" name="group_description">'.$data['group_description'].'</td>';
                                        echo '<td>
                                        <button class="btn btn-link text-dark" onclick="get_group_detail('.$data['id_group'].')" data-bs-toggle="modal" data-bs-target="#see_group_detail"><i class="fa-solid fa-eye"></i></button>

                                        <a href="group_user_edit.php?id='.$data['id_group'].'" class="btn btn-link text-warning"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <button class="btn btn-link text-danger" onclick="delete_group('.$data['id_group'].')"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>';
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

    <!-- Modal -->
    <div class="modal fade" id="see_group_detail" tabindex="-1" aria-labelledby="see_group_detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="see_group_detail">Details du group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="see_group-content">

                </div>
            </div>
        </div>
    </div>
    <?php 
        include('../includes/include-footer.php');
        include('../includes/include-script.php');
    ?>
        <script src="/dashboard/assets/js/dashboard_script.js" class="noreload"></script>
        <div id="scripttoreload">                
            <script src="/dashboard/assets/js/group_user.js"></script>
        </div>
    </div>
    </div>
</body>

</html>