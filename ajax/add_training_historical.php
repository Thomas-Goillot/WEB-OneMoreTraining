<?php 
session_start(); 
include('../includes/include-bdd.php');
include('../includes/include-functions.php');

    $id_training = $_GET['id_training'];
    $id_user = $_SESSION['id_user'];

    $add = $bdd->prepare("INSERT INTO TRAINING_HISTORICAL (id_training, id_user,training_duration) VALUES (:id_training, :id_user,'00:10:30')");
    $add->execute([
        'id_training' => $id_training,
        'id_user' => $id_user
    ]);

?>