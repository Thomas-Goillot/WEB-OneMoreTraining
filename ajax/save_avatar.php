<?php 

session_start();

include('../includes/include-bdd.php');
include('../includes/include-functions.php');

if(!empty($_GET['head']) && !empty($_GET['eyes']) && !empty($_GET['nose']) && !empty($_GET['mouth']) && !empty($_GET['brows'])){
    $head = explode('/', $_GET['head'])[6].'/'.explode('/', $_GET['head'])[7];
    $eyes = explode('/', $_GET['eyes'])[6].'/'.explode('/', $_GET['eyes'])[7];
    $nose = explode('/', $_GET['nose'])[6].'/'.explode('/', $_GET['nose'])[7];
    $mouth = explode('/', $_GET['mouth'])[6].'/'.explode('/', $_GET['mouth'])[7];
    $brows = explode('/', $_GET['brows'])[6].'/'.explode('/', $_GET['brows'])[7];


    $query = $bdd->prepare('SELECT id_avatar FROM AVATAR WHERE id_user = ?');
    $query->execute([$_SESSION['id_user']]);
    $result = $query->rowCount();
    
    if($result== 0){
        $query = $bdd->prepare('INSERT INTO AVATAR (id_user, head, eyes, nose, mouth, brows) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$_SESSION['id_user'], $head, $eyes, $nose, $mouth, $brows]);
    }else{
        $query = $bdd->prepare('UPDATE AVATAR SET head = ?, eyes = ?, nose = ?, mouth = ?, brows = ? WHERE id_user = ?');
        $query->execute([$head, $eyes, $nose, $mouth, $brows, $_SESSION['id_user']]);
    }
    
    if($query){
        echo 'val:Avatar enregistré avec succès';

    }else{
        echo 'err:Erreur lors de l\'enregistrement de l\'avatar';
    }
}
else{
    echo "err:Merci de ne pas modifier le code";
}

?>