<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    
    $actual_page = "edit_training.php";

    include('../includes/include-session-check.php');
    
    include('../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT id_user,firstname,surname,permissions_level FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    //SI pas training de l'utilisateur redirigé vers list programme
    $req_id_training = $bdd->prepare('SELECT COUNT(id_training) AS id FROM TRAINING WHERE id_training = ? AND id_user = ?');
    $req_id_training->execute(array($_GET['id'],$_SESSION['id_user']));
    $req_id_training_info = $req_id_training->fetch(); 

    if($req_id_training_info['id'] == 0){
        header('Location: training.php');
    }

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

                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><a href="training_user.php">Listes des Programmes</a> <span class="text-muted">/</span> Programme </li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-title">
                            <i class="fa-solid fa-dumbbell"></i>
                            Programme
                        </div>
                        <div class="card-body">
                            <div id="exercise_list_msg_box">

                            </div>
                            <div class="table-responsive">
                                <!-- <button type="submit" class="btn btn-success float-end"><i
                                        class="fa-solid fa-check"></i> Enregistrer</button> -->
                                <button class="btn btn-link float-end" onclick="create_exercise()"><i
                                        class="fa-solid fa-plus"></i></button>
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th scope="col">Ordre</th>
                                            <th scope="col">Nom exercice</th>
                                            <th scope="col">Durée/Rép</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exercise_list">
                                        <?php
                                        $id = $_GET['id']; 
                                        if(is_numeric($id)){
                                            $req_training = $bdd->prepare(
                                            "SELECT
                                            id_training,id_training_order,TRAINING_ORDER.id_exercise,exercise_order,duration,exercise_name
                                            FROM TRAINING_ORDER,EXERCISE
                                            WHERE id_training = ?
                                            AND TRAINING_ORDER.id_exercise = EXERCISE.id_exercise
                                            ORDER BY exercise_order;
                                            ");
                                            $req_training->execute(array($id));
                                            $req_training_info = $req_training->fetchAll();

                                            for ($i=0; $i < count($req_training_info) ; $i++) {
                                                echo '<tr class="text-center align-middle" name="id_training" value="'.$id.'">';
                                                echo '<td name="id_training_order" value="'.$req_training_info[$i]['id_training_order'].'">'.$req_training_info[$i]['exercise_order'].'</td>';
                                                echo '<td name="id_exercise" value="'.$req_training_info[$i]['id_exercise'].'">
                                                    '.$req_training_info[$i]['exercise_name'].'

                                                    <button class="btn btn-link text-warning" onclick="get_id_training_order(this); search();" data-bs-toggle="modal" data-bs-target="#see_exercise"><i
                                                            class="fa-solid fa-pencil"></i></button>
                                                    </td>';
                                                    if($req_training_info[$i]['duration'] == NULL ){
                                                        echo '<td><input type="text" class="form-control" placeholder="Ex: 15 ou 1m30" style="display: inline-block; width: 40%;">
                                                        <button class="btn btn-link text-success" onclick="setduration(this,'.$req_training_info[$i]['id_training_order'].')"><i class="fa-solid fa-check"></i></button>
                                                        </td>';
                                                    }
                                                    else{
                                                        echo '<td><input type="text" class="form-control" value="'.$req_training_info[$i]['duration'].'" style="display: inline-block; width: 40%;">
                                                        <button class="btn btn-link text-success" onclick="setduration(this,'.$req_training_info[$i]['id_training_order'].')"><i class="fa-solid fa-check"></i></button></td>';
                                                    }
                                                    
                                                echo '<td>
                                                    <button class="btn btn-link text-danger"
                                                        onclick="delete_exercise_training(this)"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                </td>';
                                                echo '</tr>';
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <!-- <button type="submit" class="btn btn-success float-end"><i class="fa-solid fa-check"></i> Enregistrer</button> -->
                                <button class="btn btn-link float-end" onclick="create_exercise()"><i class="fa-solid fa-plus"></i></button>
                                </form>
                            </div>


                        </div>
                    </div>
            </main>

            <!-- Modal exercise-->
            <div class="modal fade" id="see_exercise" tabindex="-1" aria-labelledby="see_exercise"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="see_exercise">Exercises</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="see_exercise_content">
                            
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="search-exercise" placeholder="Chercher un exercice" onkeyup="search()">
                                <label for="floatingInput">Chercher un exercice</label>
                            </div>
                            <div id="response_exercise" class="overflow-auto" style="height: 65vh;">

                            </div>
                            <button onclick="validexercise()" class="btn btn-primary">Valider</button>

                        </div>
                    </div>
                </div>
            </div>

            <?php 
                include('../includes/include-footer.php');
            ?>
            <?php 
                include('../includes/include-script.php');
            ?>
            <script src="/dashboard/assets/js/dashboard_script.js" class="noreload"></script>
            <div id="scripttoreload">
                <script src="/dashboard/assets/js/edit_training_user.js"></script>
            </div>

        </div>
    </div>
</body>

</html>