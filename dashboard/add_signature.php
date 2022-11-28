<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');
    
    $actual_page = "profil.php";

    include('../includes/include-session-check.php');
    
    include('../includes/include-functions.php');

    $req_user_permissions = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
    $req_user_permissions->execute(array($_SESSION['id_user']));
    $user_info = $req_user_permissions->fetch(); 

    include('../includes/include-info.php');

    include('../includes/include-head.php');
?>

<body onload="init()">
    <main>
        <h1 class="text-center pt-3">Ajouter Votre Signature</h1>
        <div class="container">
            <div id="signature_msg_box"></div>
        </div>
        <div class="d-flex justify-content-center pt-5">
            <canvas id="can" width="800" height="400" style="border:2px solid;"></canvas>
        </div>
        
        <div class="d-flex justify-content-around pt-5 pb-5">
            <a href="profil.php" class="btn btn-primary">Retour</a>
            <input type="button" class="btn btn-primary" value="Enregistrer" onclick="save()">
            <input type="button" class="btn btn-primary" value="Effacer" onclick="erase()">
        </div>
    </main>


    <script src="../dashboard/assets/js/signature.js"></script>
    <?php 
        include('../includes/include-footer.php');
    ?>
</body>
</html>