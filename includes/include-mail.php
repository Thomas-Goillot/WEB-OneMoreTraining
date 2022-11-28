<?php
/*
 * Created on Mon Apr 24 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function send_mail($to, $subject, $body) {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; // 0 = no error ; 1,2 = errors
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'OneMoreTraining.confirmation@gmail.com';
        $mail->Password   = 'projetannuel2022';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;

        //addr mail envoyeur
        $mail->setFrom('OneMoreTraining.confirmation@gmail.com', 'One More Training');

        //addr mail destinataire
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->AltBody = '';

        $mail->send();
        echo 'val:Message envoyé';
    } catch (Exception $e) {
        echo "err:Erreur lors de l'envoie du message, Error: {$mail->ErrorInfo}";
    }
}
?>