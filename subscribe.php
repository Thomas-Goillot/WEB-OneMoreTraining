<?php
/*
 * Created on Mon mai 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

    include('includes/include-bdd.php');

    $actual_page = "subscribe.php";    

    include('includes/include-session-check.php');

    include('includes/include-functions.php');

    include('includes/include-info.php');

    include('includes/include-head.php');

    $id = $_GET['id'];

    /* if(!isset($id) || $id < 3) {
        header("Location: index.php");
    } */ 

    $query = $bdd->prepare("SELECT * FROM SUBSCRIBE WHERE id_subscribe = ?");
    $query->execute(array($id));
    $article = $query->fetch();

    if(!$article) {
        header("Location: index.php");
    } 
?>
<link rel="stylesheet" href="/payment/styles.css">
<body class="pt-5">



  <div class="container d-flex justify-content-center">
      <figure class="card card-product-grid card-lg">
          <a href="#" class="img-wrap" data-abc="true">
              <img src="/assets/img/<?= $article['subscribe_image']?>">
          </a>
          <figcaption class="info-wrap">
              <div class="row">
                  <div class="col-md-9 col-xs-9">
                      <a href="#" class="title" data-abc="true"><?= $article['subscribe_name']?></a>
                      <span class="rated">Abonnement pour 1 an</span>
                  </div>
              </div>
          </figcaption>
          <div class="bottom-wrap-payment">
              <figcaption class="info-wrap">
                  <div class="row">
                      <div class="col-md-9 col-xs-9">
                          <a href="#" class="title" data-abc="true"><?= $article['subscribe_price']?> €</a>
                      </div>
                      <div class="col-md-3 col-xs-3">
                          <div class="rating text-right">/ an </div>
                      </div>
                  </div>
              </figcaption>
          </div>
          <div class="bottom-wrap">
              <a href="/payment/payment.php?id=<?= $id?>" class="btn btn-primary float-right" data-abc="true">
                  Acheter</a>
              <div class="price-wrap">
                  <a href="/" class="btn btn-warning float-left" data-abc="true"> Annuler </a>
              </div>
          </div>
      </figure>
  </div>
</body>

</html>