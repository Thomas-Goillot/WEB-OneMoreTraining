<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('../includes/include-bdd.php');

    $actual_page = "success.php";    

    include('../includes/include-session-check.php');

    include('../includes/include-functions.php');

    include('../includes/include-info.php');

    include('../includes/include-head.php');

    $id = $_GET['id'];

    if(!isset($id) || $id < 3) {
        header("Location: ../index.php");
    }

    $query = $bdd->prepare("SELECT * FROM SUBSCRIBE WHERE id_subscribe = ?");
    $query->execute(array($id));
    $article = $query->fetch();

    if(!$article) {
        header("Location: ../index.php");
    } 

    $query = $bdd->prepare("UPDATE GIVE_TOOL SET id_subscribe = ? WHERE id_user = ?");
    $query->execute(array($id, $_SESSION['id_user']));

?>
<link rel="stylesheet" href="styles.css">
<body class="pt-5">

  <div class="container d-flex justify-content-center">
      <figure class="card card-product-grid card-lg">
          <a href="#" class="img-wrap" data-abc="true">
              <img src="/assets/img/validation.png">
          </a>
          <figcaption class="info-wrap">
              <div class="row">
                  <div class="col-md-9 col-xs-9">
                      <a href="#" class="title" data-abc="true">Merci beaucoup pour votre Achat</a>
                      <span class="rated">L'equipe OMT</span>
                  </div>
              </div>
          </figcaption>
<!--           <div class="bottom-wrap-payment">
              <figcaption class="info-wrap">
                  <div class="row">
                      <div class="col-md-9 col-xs-9">
                          <a href="#" class="title" data-abc="true"><i class="fa-solid fa-check"></i> Votre facture vous a été envoyé par mail</a>
                      </div>
                  </div>
              </figcaption>
          </div>      -->     
          <div class="bottom-wrap">
              <button onclick="sendmail(<?=$_SESSION['id_user']?>)" class="btn btn-primary float-right" data-abc="true">Envoyez ma facture</button>
              <a href="/dashboard/profil.php" class="btn btn-primary float-right" data-abc="true">Voir mon profil</a>
          </div>
      </figure>
  </div>
  <?php 
    include('../includes/include-script.php');
  ?>
  <script src="success.js"></script>
</body>

</html>