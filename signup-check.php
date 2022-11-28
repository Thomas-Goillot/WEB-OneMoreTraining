<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

session_start();
include('includes/include-bdd.php');
include('includes/include-functions.php');
include('includes/include-mail.php');

if(isset($_POST)){
    $firstname = htmlspecialchars($_POST['firstnameinput']);
    $lastname = htmlspecialchars($_POST['lastnameinput']);
    $dayb = htmlspecialchars($_POST['dayinput']);
    $monthb = htmlspecialchars($_POST['monthinput']);
    $yearb = htmlspecialchars($_POST['yearinput']);
    $mail1 = htmlspecialchars($_POST['mail1input']);
    $mail2 = htmlspecialchars($_POST['mail2input']);
    $phone = htmlspecialchars($_POST['phoneinput']);
    $type = htmlspecialchars($_POST['typeinput']);
    $pwd1 = htmlspecialchars($_POST['pwd1input']);
    $pwd2 = htmlspecialchars($_POST['pwd2input']);

    if(strlen($firstname) <= 20 && strlen($firstname) >= 1 ){
        if(strlen($lastname) <= 20 && strlen($lastname) >= 1 ){
            if($monthb >= 1 && $monthb <= 12){
                if($yearb > 1900 && $yearb < date("Y")){
                    $number_of_day = days_in_month($monthb, $yearb);
                    if($dayb > 0 && $dayb <= 31){
                        if($mail1 === $mail2){
                            if(filter_var($mail1, FILTER_VALIDATE_EMAIL)){
                                $reqmail = $bdd->prepare("SELECT mail FROM OMT_USER WHERE mail = ?");
                                $reqmail->execute(array($mail1));
                                $mailexist = $reqmail->rowCount();
                                if($mailexist == 0){
                                    
                                    $number = mt_rand(100000,999999);
                                    $add_user = $bdd->prepare("INSERT INTO 
                                    OMT_USER(firstname,surname,mail,password,phone_number,date_of_birth,mail_verified) 
                                    VALUES (:firstname,:surname,:mail,:password,:phone_number,:date_of_birth,:number)");

                                    $add_user->execute(
                                    ['firstname' => $firstname,
                                    'surname' => $lastname,
                                    'mail' => $mail1,
                                    'password' => pwd_hash($pwd1),
                                    'date_of_birth' => "$dayb/$monthb/$yearb",
                                    'phone_number' => $phone,
                                    'number' => $number
                                    ]);

                                    $req_user_info = $bdd->prepare('SELECT id_user FROM OMT_USER WHERE mail = ?');
                                    $req_user_info->execute(array($mail1));
                                    $user_info = $req_user_info->fetch(); 
                                    //SELECT SCOPE_IDENTITY();
                                    
                                    $_SESSION['id_user'] = $user_info['id_user'];
                                    $_SESSION['logged_in'] = true;
                                    $_SESSION['last_activity'] = time();
                                    $_SESSION['expire_time'] = 3*60*60;

                                    $actual_page = "signin.php";
                
                                    $add_user_log = $bdd->prepare('INSERT INTO USER_LOG (activity,id_user) VALUES (?,?)');
                                    $add_user_log->execute(array($actual_page,$_SESSION['id_user'])); 
                                    
                                    $add_user_visit = $bdd->prepare('INSERT INTO USER_VISIT (id_user) VALUES (?)');
                                    $add_user_visit->execute(array($user_info['id_user'])); 

                                    $add_user_visit = $bdd->prepare('INSERT INTO GIVE_TOOL (id_user,id_subscribe) VALUES (?,?)');
                                    $add_user_visit->execute(array($user_info['id_user'],2)); 

                                    send_mail($mail1, "Confirmation de votre compte", file_get_contents(checkhost().$_SERVER['HTTP_HOST'].'/assets/mails/confirm_mail.php?id='.$user_info['id_user']));
                                    
                                    header('Location: main.php');

                                }
                                else{
                                    header('Location: register.php?err=mail deja utilisé');
                                }
                                
                            }
                            else{
                                header('Location: register.php?err=mauvais format de mail');
                            }

                        }
                        else{
                            header('Location: register.php?err=mail différent');
                        }
                    }
                    else{
                        header('Location: register.php?err=date incorrect');
                    }
                }
                else{
                    header('Location: register.php?err=date incorrect');
                }
                
            }
            else{
                header('Location: register.php?err=mauvais mois');
            }
            
        }
        else{
            header('Location: register.php?err=nom famille trop long');
        }
    }
    else{
        header('Location: register.php?err=Prenom entre 1 et 20 caractères');
    }
}


?>