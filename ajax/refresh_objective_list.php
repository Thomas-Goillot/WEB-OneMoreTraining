<?php
session_start();
include('../includes/include-bdd.php');
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