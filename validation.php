<?php 
include('includes/include-bdd.php');
$id = $_GET['id'];
$code = $_GET['pwd'];

//requete sql pour recuperer mail_verified a partir de l'id
$req_mail_verified = $bdd->prepare('SELECT mail_verified FROM OMT_USER WHERE id_user = ?');
$req_mail_verified->execute(array($id));
$mail_verified = $req_mail_verified->fetch();

if($code == $mail_verified['mail_verified']){

    $req_update_mail_verified = $bdd->prepare('UPDATE OMT_USER SET mail_verified = ? WHERE id_user = ?');
    $req_update_mail_verified->execute(array(1,$id));
    
    header('Location: /dashboard/profil.php?val=Mail confirmé avec succès');
}
else{
   echo "<div class='alert alert-danger' role='alert'>Code invalide</div>";
}
?>