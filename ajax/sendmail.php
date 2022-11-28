<?php  
include('../includes/include-bdd.php');
include('../includes/include-functions.php');
include('../includes/include-mail.php');

$id = $_GET['id_user'];
$mailfile = $_GET['mail_file'];

switch ($mailfile) {
    case 'confirm_mail.php':
        $subject = "Confirmation de votre inscription";
        break;
    case 'recent_purchase.php':
        $subject = "Votre Nouvelle commande";
        break;
    
    default:
        $subject = "One More Training";
        break;
}

$req_user_info = $bdd->prepare('SELECT mail FROM OMT_USER WHERE id_user = ?');
$req_user_info->execute(array($id));
$user_info = $req_user_info->fetch();

send_mail($user_info['mail'], $subject, file_get_contents(''.checkhost().$_SERVER['HTTP_HOST'].'/assets/mails/'.$mailfile.'?id_user='.$id));

?>