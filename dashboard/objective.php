<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    
    $actual_page = "objective.php";

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
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard OMT</h1>

                    <div class="col-lg-12">

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Vos Objectifs</li>
                        </ol>

                        <div class="card mb-4">

                            <div class="card-title">
                                <i class="bi bi-table"></i>
                                Listes de vos objectifs
                                <button class="btn btn-link text-dark float-end" data-bs-toggle="modal" data-bs-target="#add_objective" ><i
                                    class="fa-solid fa-plus"></i>
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center align-middle">
                                                <th>#</th>
                                                <th>Nom</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="objective_list">
                                            <?php
                                                $req_objectives = $bdd->prepare('SELECT id_objective,name,description FROM OBJECTIVE WHERE id_user = ?');
                                                $req_objectives->execute(array($_SESSION['id_user']));
                                                while($objective = $req_objectives->fetch()) {
                                                    echo '<tr class="text-center align-middle">';
                                                    echo '<td>'.$objective['id_objective'].'</td>';
                                                    echo '<td>'.$objective['name'].'</td>';
                                                    echo '<td>'.$objective['description'].'</td>';
                                                    echo '<td>';
                                                    echo '<button class="btn btn-link text-danger" onclick="delete_objective('.$objective['id_objective'].')"><i class="fa-solid fa-trash-can"></i></button>';
                                                    echo '</td>';
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
    <div class="modal fade" id="add_objective" tabindex="-1" aria-labelledby="add_objective" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_objective_title">Ajouter un objectif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="add_objective_content">

                    <div class="form-group">
                        <label for="name_objective">Nom de l'objectif</label>
                        <input type="text" class="form-control" name="name_objective" id="name_objective" placeholder="Nom de l'objectif" required>
                    </div>
                    <div class="form-group">
                        <label for="description_objective">Description de l'objectif</label>
                        <textarea class="form-control" placeholder="Description de l'objectif" id="description_objective"
                            style="height: 100px" name="description_objective" required></textarea>
                    </div>
                    <hr class="mt-3 mb-3">
                    <button class="btn btn-primary" onclick="add_objective()">Ajouter</button>


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
        <script src="/dashboard/assets/js/objective.js"></script>
    </div>
    </div>
    </div>
</body>

</html>