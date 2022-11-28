<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

session_start();

include('includes/include-bdd.php');

$actual_page = "logout.php";    

$last_user_log = $bdd->prepare('SELECT activity FROM USER_LOG WHERE id_user = ? ORDER BY date_of_activity DESC LIMIT 1');
$last_user_log->execute(array($_SESSION['id_user']));
$last_user_activity = $last_user_log->fetchAll();

if($last_user_activity[0]['activity'] != $actual_page){
   $add_user_log = $bdd->prepare('INSERT INTO USER_LOG (activity,id_user) VALUES (?,?)');
   $add_user_log->execute(array($actual_page,$_SESSION['id_user'])); 
}

$_SESSION = array();
session_destroy();
session_unset();


setcookie('login', '');
setcookie('pass_hache', '');
 
header('Location: /index.php');
 
 
?>