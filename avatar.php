<?php
/*
 * Created on Mon Apr 19 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('includes/include-bdd.php');

    $actual_page = "avatar.php";    

    include('includes/include-session-check.php');

    include('includes/include-functions.php');

    include('includes/include-info.php');

    include('includes/include-head.php');
?>
<body>
    <div id="avatar_msg_box">

    </div>
    <div class="container-fluid row d-flex justify-content-center align-content-center">
        <div class="col-lg-6 container mt-5" id="avatar_preview">
            <?php 
                $req = $bdd->prepare('SELECT id_user FROM AVATAR WHERE id_user = ?');
                $req->execute(array($_SESSION['id_user']));
                $avatar = $req->rowCount();

                if ($avatar == 1) {
                        
                    $req = $bdd->prepare('SELECT * FROM AVATAR WHERE id_user = ?');
                    $req->execute(array($_SESSION['id_user']));
                    $avatar = $req->fetch();
                    echo '
                    <img src="assets/img/avatar/'.$avatar['head'].'" class="superpose img-fluid rounded-pill" id="head" alt="" loading="lazy">
                    <img src="assets/img/avatar/'.$avatar['eyes'].'" class="superpose img-fluid" id="eyes" alt="" loading="lazy">
                    <img src="assets/img/avatar/'.$avatar['nose'].'" class="superpose img-fluid" id="nose" alt="" loading="lazy">
                    <img src="assets/img/avatar/'.$avatar['mouth'].'" class="superpose img-fluid" id="mouth" alt="" loading="lazy">
                    <img src="assets/img/avatar/'.$avatar['brows'].'" class="superpose img-fluid" id="brows" alt="" loading="lazy">
                    ';
                }
                else{
                    echo '
                    <img src="assets/img/avatar/head/'.random_img('assets/img/avatar/head/').'" class="superpose img-fluid rounded-pill" id="head" alt="" loading="lazy">
                    <img src="assets/img/avatar/eyes/'.random_img('assets/img/avatar/eyes/').'" class="superpose img-fluid" id="eyes" alt="" loading="lazy">
                    <img src="assets/img/avatar/nose/'.random_img('assets/img/avatar/nose/').'" class="superpose img-fluid" id="nose" alt="" loading="lazy">
                    <img src="assets/img/avatar/mouth/'.random_img('assets/img/avatar/mouth/').'" class="superpose img-fluid" id="mouth" alt="" loading="lazy">
                    <img src="assets/img/avatar/brows/'.random_img('assets/img/avatar/brows/').'" class="superpose img-fluid" id="brows" alt="" loading="lazy">
                    ';
                    
                }

            ?>
            
        </div>
        <div class="col-lg-6 container">
            <ul class="nav nav-tabs justify-content-center align-content-center">
                <li class="nav-item">
                    <a class="nav-link nav-list active text-dark"
                        onclick="avatar_items_list(this,'head_list')">Cheveux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-list text-dark" onclick="avatar_items_list(this,'eyes_list')">Yeux</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-list text-dark" onclick="avatar_items_list(this,'nose_list')">Nez</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-list text-dark" onclick="avatar_items_list(this,'mouth_list')">Bouche</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-list text-dark" onclick="avatar_items_list(this,'brows_list')">Sourcils</a>
                </li>
            </ul>
            <div class="row container-fluid pt-5 items show" id="head_list">

                <?php 
                $parameter = 'head';
                $dir = 'assets/img/avatar/'.$parameter.'/';
                $files = scandir($dir);
                foreach($files as $file){
                    if(strpos($file, $parameter) !== false){
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <label class="form-check-label item" for="'.$file.'">
                                <img src="'.$dir.$file.'" class="img-fluid rounded-circle" alt="" data-id="'.$parameter.'" loading="lazy">
                                <input type="radio" class="form-check-input" name="'.$parameter.'_radio" id="'.$file.'" onclick="change_item(this)">
                            </label>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="row container-fluid pt-5 items hide" id="eyes_list">
                <?php 
                $parameter = 'eyes';
                $dir = 'assets/img/avatar/'.$parameter.'/';
                $files = scandir($dir);
                foreach($files as $file){
                    if(strpos($file, $parameter) !== false){
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <label class="form-check-label item" for="'.$file.'">
                                <img src="'.$dir.$file.'" class="img-fluid rounded-circle" alt="" data-id="'.$parameter.'" loading="lazy">
                                <input type="radio" class="form-check-input" name="'.$parameter.'_radio" id="'.$file.'" onclick="change_item(this)">
                            </label>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="row container-fluid pt-5 items hide" id="nose_list">
                <?php 
                $parameter = 'nose';
                $dir = 'assets/img/avatar/'.$parameter.'/';
                $files = scandir($dir);
                foreach($files as $file){
                    if(strpos($file, $parameter) !== false){
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <label class="form-check-label item" for="'.$file.'">
                                <img src="'.$dir.$file.'" class="img-fluid rounded-circle" alt="" data-id="'.$parameter.'" loading="lazy">
                                <input type="radio" class="form-check-input" name="'.$parameter.'_radio" id="'.$file.'" onclick="change_item(this)">
                            </label>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="row container-fluid pt-5 items hide" id="mouth_list">
                <?php 
                $parameter = 'mouth';
                $dir = 'assets/img/avatar/'.$parameter.'/';
                $files = scandir($dir);
                foreach($files as $file){
                    if(strpos($file, $parameter) !== false){
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <label class="form-check-label item" for="'.$file.'">
                                <img src="'.$dir.$file.'" class="img-fluid rounded-circle" alt="" data-id="'.$parameter.'" loading="lazy">
                                <input type="radio" class="form-check-input" name="'.$parameter.'_radio" id="'.$file.'" onclick="change_item(this)">
                            </label>
                        </div>';
                    }
                }
                ?>
            </div>
            <div class="row container-fluid pt-5 items hide" id="brows_list">
                <?php 
                $parameter = 'brows';
                $dir = 'assets/img/avatar/'.$parameter.'/';
                $files = scandir($dir);
                foreach($files as $file){
                    if(strpos($file, $parameter) !== false){
                        echo '
                        <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                            <label class="form-check-label item" for="'.$file.'">
                                <img src="'.$dir.$file.'" class="img-fluid rounded-circle" alt="" data-id="'.$parameter.'" loading="lazy">
                                <input type="radio" class="form-check-input" name="'.$parameter.'_radio" id="'.$file.'" onclick="change_item(this)">
                            </label>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <a href="/dashboard/profil.php" class="btn btn-danger mt-3" >Retour</a>
            </div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-primary mt-3" onclick="random_avatar()">Aléatoire</button>
            </div>
            <div class="col-lg-4">
                <button type="button" class="btn btn-success mt-3 " onclick="save_avatar()" >Enregistrer</button>
            </div>
        </div>
    </div>



    <script src="assets/js/avatar.js"></script>
</body>

</html>