<?php 
session_start();
include('../includes/include-bdd.php');

$name = htmlspecialchars($_GET['name']);
$description = htmlspecialchars($_GET['description']);

//if name is < 35 characters and description is < 255 characters add objective to db
if(strlen($name) <= 35 && strlen($name) > 0 && strlen($description) < 255 && strlen($description) > 0) {
    $req_add_objective = $bdd->prepare('INSERT INTO OBJECTIVE (id_user,name,description) VALUES (?,?,?)');
    $req_add_objective->execute(array($_SESSION['id_user'],$name,$description));
}
else{
    echo '<script>alert("Le nom doit comporter au maximum 35 caractère et la description 255");</script>';
}


?>