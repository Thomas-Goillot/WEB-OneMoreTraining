<?php 
    include('../includes/include-bdd.php');
    include('../includes/include-functions.php');

    $id_training = $_GET['id_training'];
    $exercice_order = $_GET['exercise_order'];

    $query = $bdd->prepare("SELECT * FROM TRAINING_ORDER WHERE id_training = :id_training AND exercise_order = :exercise_order");
    $query->execute([
        'exercise_order' => $exercice_order, 
        'id_training' => $id_training
    ]);
    $training_order = $query->fetchAll();

    $query = $bdd->prepare("SELECT * FROM EXERCISE WHERE id_exercise = :id_exercise");
    $query->execute([
        ':id_exercise' => $training_order[0]['id_exercise']
    ]);
    $exercice = $query->fetch();

    $_next = $bdd->prepare("SELECT MAX(exercise_order) as _last FROM TRAINING_ORDER WHERE id_training = :id_training");
    $_next->execute([
        'id_training' => $id_training
    ]);
    $next = $_next->fetch();
?>

<h5 class="card-title text-center"><?= $exercice['exercise_name'] ?></h5>
<p class="card-text"><?= $exercice['exercise_info'] ?></p>

<?php 
echo '<button class="btn btn-danger" onclick="stop('.$id_training.')">Annuler</button>';
if($exercice_order == $next['_last']){
    echo '<button class="btn btn-danger float-end" onclick="stop('.$id_training.')">Terminer</button>';
}else{
    echo '<button class="btn btn-primary float-end" onclick="get_info('.$id_training.', '.$exercice_order.')">Suivant</button>';
}
?>