<?php 
/*
 * Created on Wed Apr 06 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

require('../includes/include-fpdf.php');

include('../includes/include-bdd.php');

$actual_page = "user_information_file";

include('../includes/include-session-check.php');

include('../includes/include-functions.php');

$id_user = $_GET['id_user'];//id_user_request

$req_user_permissions = $bdd->prepare('SELECT permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$user_info = $req_user_permissions->fetch(); 

if($user_info['permissions_level'] == 1 || $id_user == $_SESSION['id_user']){

class PDF extends FPDF {

    function title($title){
        $this->SetFont('Arial','B',15);
        $this->Cell(60);
        $this->Cell(70,10,$title,1,0,'C');
        $this->Ln(20);
    }

    function TableFetch($header, $data)
    {
        $w = array();

        for ($i=0; $i < count($header); $i++) { 
            array_push($w, 190 / count($header));
        }

        createHeader($this,$header, $w);

        foreach($data as $key => $row)
        {
            if($key != "password"){
                $this->Cell($w[0],6,$key,'LR');
                $this->Cell($w[1],6,$row,'LR');
                $this->Ln();
            }
        }

        $this->Cell(array_sum($w),0,'','T');
    }

    function TableFetchAll($header, $data)
    {

        $w = array();

        for ($i=0; $i < count($header); $i++) { 
            array_push($w, (190/ count($header)));
        }

        createHeader($this,$header, $w);  

        for($i=0;$i<count($data);$i++){
            $c = 0;
            foreach($data[$i] as $row)
            {
                $this->Cell($w[$c],6,$row,'LR');
                $c++;
            }
            $this->Ln();
        }

        $this->Cell(array_sum($w),0,'','T');
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'(c) Your Data One More Training',0,0,'C');
    }
    function add_signature(){
        $this->Image('../assets/img/signatures/signature_'.$_SESSION['id_user'].'.png',60,150,100,100);
    }
    

}

function createHeader($e,$header, $w){

    for($i=0;$i<count($header);$i++){
        $e->Cell($w[$i],7,$header[$i],1,0,'C');
    }
    $e->Ln();   
}
    $pdf = new PDF();
    $pdf->SetFont('Arial','',14);


    //Information Utilisateurs
    $get_users_info = $bdd->prepare('SELECT * FROM OMT_USER WHERE id_user = ?');
    $get_users_info->execute(array($id_user));
    $donnees = $get_users_info->fetch();

    $pdf->AddPage();
    $header = array('Nom', 'Information');
    $title = "Informations Utilisateur";
    $pdf->title($title);
    $pdf->TableFetch($header,$donnees);


    //Training Personnel
    $get_users_training = $bdd->prepare('SELECT name_training,privacy_training,creation_date FROM TRAINING WHERE id_user = ?');
    $get_users_training->execute(array($id_user));
    $data = $get_users_training->fetchAll(PDO::FETCH_ASSOC);
    
    $pdf->AddPage();
    $header = array("Nom", "privacy_training", "Date de création");
    $title = "Training Personnel";
    $pdf->title($title);
    $pdf->TableFetchAll($header,$data);

    //Historique Training
    $get_users_training_historical = $bdd->prepare('SELECT name_training,training_duration,training_date FROM TRAINING_HISTORICAL,TRAINING WHERE TRAINING_HISTORICAL.id_user = ? AND TRAINING_HISTORICAL.id_training = TRAINING.id_training');
    $get_users_training_historical->execute(array($id_user));
    $data = $get_users_training_historical->fetchAll(PDO::FETCH_ASSOC);
    
    $pdf->AddPage();
    $header = array("Nom", "training_duration", "training_date");
    $title = "Historique Training";
    $pdf->title($title);
    $pdf->TableFetchAll($header,$data);

    //Objectif
    $get_users_objective = $bdd->prepare('SELECT name,description FROM OBJECTIVE WHERE id_user = ?');
    $get_users_objective->execute(array($id_user));
    $data = $get_users_objective->fetchAll(PDO::FETCH_ASSOC);
    
    $pdf->AddPage();
    $header = array("Nom", "description");
    $title = "Objective";
    $pdf->title($title);
    $pdf->TableFetchAll($header,$data);

    //Commentaire
    $get_users_comment = $bdd->prepare('SELECT name_training,stars,comment,date_of_add,name_training FROM APPRECIATION,TRAINING WHERE APPRECIATION.id_user = ? AND APPRECIATION.id_training = TRAINING.id_training');
    $get_users_comment->execute(array($id_user));
    $data = $get_users_comment->fetchAll(PDO::FETCH_ASSOC);
    
    $pdf->AddPage();
    $header = array("Nom", "Etoiles","Date ajout", "Commentaire");
    $title = "Commentaire";
    $pdf->title($title);
    $pdf->TableFetchAll($header,$data);
    
    $pdf->add_signature();
    $pdf->Output('D',''.$donnees['firstname'].'-'.$donnees['surname'].'.pdf');

}
else{
    header('location: /index.php');
}
?>