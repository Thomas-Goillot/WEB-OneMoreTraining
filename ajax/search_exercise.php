<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$search = htmlspecialchars($_GET['q']);

if(isset($search)){
    $get_exercise = $bdd->prepare('SELECT * FROM EXERCISE WHERE exercise_name LIKE ? ORDER BY exercise_name');
    $get_exercise->execute(array("$search%"));
    $get_exercise_info = $get_exercise->fetchAll();
}
else{
    $get_exercise = $bdd->prepare('SELECT * FROM EXERCISE ORDER BY exercise_name');
    $get_exercise->execute();
    $get_exercise_info = $get_exercise->fetchAll();
}
for ($i=0; $i < count($get_exercise_info) ; $i++) { 
    echo '
    <label class="card mb-3 form-check-label " for="exercise'.$get_exercise_info[$i]['id_exercise'].'" style="cursor: pointer;">
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" value="'.$get_exercise_info[$i]['id_exercise'].'" type="radio" name="exercise" id="exercise'.$get_exercise_info[$i]['id_exercise'].'">

                '.$get_exercise_info[$i]['exercise_name'].'
                
            </div>
        </div>
    </label>';
}
?>
