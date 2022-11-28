<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

session_start();

$actual_page = "login.php";

include('includes/include-functions.php');
include('includes/include-bdd.php');

if(isset($_POST['sign_in_form'])) {

    $mail = htmlspecialchars($_POST['mailinput']);
	$pwd = pwd_hash($_POST['pwdinput']);
    $captcha_status = $_POST['captcha_validation'];

    if(!empty($mail) AND !empty($pwd)){
        if($captcha_status == 'true'){

            $req_user = $bdd->prepare("SELECT * FROM OMT_USER WHERE mail = ? AND password = ?");
            $req_user->execute(array($mail, $pwd));
            $user_exist = $req_user->rowCount();

            $req_user2 = $bdd->prepare("SELECT banned FROM OMT_USER WHERE mail = ? AND password = ?");
            $req_user2->execute(array($mail, $pwd));
            $user_is_banned = $req_user2->fetch();

            if($user_exist == 1){ 
                if($user_is_banned['banned'] == 0){

                    $req_user_info = $bdd->prepare('SELECT id_user FROM OMT_USER WHERE mail = ?');
                    $req_user_info->execute(array($mail));
                    $user_info = $req_user_info->fetch(); 
                    
                    $_SESSION['id_user'] = $user_info['id_user'];
                    $_SESSION['logged_in'] = true;
                    $_SESSION['last_activity'] = time();
                    $_SESSION['expire_time'] = 3*60*60;

                    $add_user_log = $bdd->prepare('INSERT INTO USER_LOG (activity,id_user) VALUES (?,?)');
                    $add_user_log->execute(array($actual_page,$_SESSION['id_user'])); 
                    
                    $add_user_visit = $bdd->prepare('INSERT INTO USER_VISIT (id_user) VALUES (?)');
                    $add_user_visit->execute(array($user_info['id_user'])); 

                    header('Location: main.php');
                }
                else{
                    header('Location: login.php?err=Vous avez été banni par l\'administrateur.');
                }
            } 
            else 
            {
                header('Location: login.php?err=Mot de passe ou mail incorrect !');
            }
        }
        else{
            header('Location: login.php?err=Le captcha n\'est pas validé');
        }
    } 
    else 
    {
        header('Location: login.php?err=Tous les champs doivent être complétés !');
    }
}
 
?>