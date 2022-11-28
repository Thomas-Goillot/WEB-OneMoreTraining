<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');
$id = $_GET['id_training'];

if(is_numeric($id)){
    $req_training = $bdd->prepare(
    "SELECT id_training,id_training_order,TRAINING_ORDER.id_exercise,exercise_order,duration,exercise_name
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