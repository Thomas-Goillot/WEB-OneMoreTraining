<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */
require('../includes/include-fpdf.php');

include('../includes/include-bdd.php');

$actual_page = "user_information_file";

include('../includes/include-session-check.php');

include('../includes/include-functions.php');

define('EURO',chr(128));

$id_user = $_GET['id'];

$req_user_permissions = $bdd->prepare('SELECT firstname,permissions_level FROM OMT_USER WHERE id_user = ?');
$req_user_permissions->execute(array($_SESSION['id_user']));
$userinfo = $req_user_permissions->fetch(); 

$req = $bdd->prepare('SELECT * FROM SUBSCRIBE WHERE id_subscribe = (SELECT id_subscribe FROM GIVE_TOOL WHERE id_user = ?)');
$req->execute(array($id_user));
$data = $req->fetch();

if($userinfo['permissions_level'] == 1 || $id_user == $_SESSION['id_user']){
    
    // le mettre au debut car plante si on declare $mysqli avant !
    $pdf = new FPDF( 'P', 'mm', 'A4' );

    $var_id_facture = $id_user.'-'.date('YmdHis');

    // on sup les 2 cm en bas
    $pdf->SetAutoPagebreak(False);
    $pdf->SetMargins(0,0,0);

        $pdf->AddPage();
        
        // logo : 80 de largeur et 55 de hauteur
        $pdf->Image('../assets/img/logo_black.png', 10, 10, 80, 55);

        // n° page en haute à droite
        $pdf->SetXY( 120, 5 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 160, 8, '1/1', 0, 0, 'C');
        
        $req = $bdd->prepare('SELECT * FROM GIVE_TOOL WHERE id_user = ?');
        $req->execute(array($id_user));
        $subscribe = $req->fetch();
        
        $champ_date = date_create($subscribe['date_of_delivery']);
        $annee = date_format($champ_date, 'Y');
        $num_fact = utf8_decode("FACTURE N° ") . $annee .'-' . mt_rand(100000,999999);
                    
        $pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(120, 15, 85, 8, "DF");
        $pdf->SetXY( 120, 15 ); $pdf->SetFont( "Arial", "B", 12 ); $pdf->Cell( 85, 8, $num_fact, 0, 0, 'C');
        
        $nom_file = "facture_" . $annee .'-' .$userinfo['firstname'].".pdf";
        
        $champ_date = date_create($subscribe['date_of_delivery']); $date_fact = date_format($champ_date, 'd/m/Y');
        $pdf->SetFont('Arial','',11); $pdf->SetXY( 122, 30 );
        $pdf->Cell( 60, 8, "MA VILLE, le " . $date_fact, 0, 0, '');
        
        $pdf->SetLineWidth(0.1); $pdf->SetFillColor(192); $pdf->Rect(5, 213, 90, 8, "DF");

        $nombre_format_francais = "Total HT : " . number_format($data['subscribe_price'] - ($data['subscribe_price'] / 100 * 5.5) , 2, ',', ' ') . ' '. EURO;
        $pdf->SetFont('Arial','',10); $pdf->SetXY( 95, 213 ); $pdf->Cell( 63, 8, $nombre_format_francais, 0, 0, 'C');

        $pdf->Rect(5, 213, 200, 8, "D"); $pdf->Line(95, 213, 95, 221); $pdf->Line(158, 213, 158, 221);

        $pdf->SetXY( 5, 225 ); $pdf->Cell( 38, 5, utf8_decode("Mode de Règlement :"), 0, 0, 'R'); $pdf->Cell( 55, 5, "Carte Bancaire", 0, 0, 'L');
        $date_ech = date('Y-m-d', strtotime($subscribe['date_of_delivery'].' + 1 year'));
        $pdf->SetXY( 5, 230 ); $pdf->Cell( 38, 5, utf8_decode("Date Echéance :"), 0, 0, 'R'); $pdf->Cell( 38, 5, $date_ech, 0, 0, 'L');
        
        $pdf->SetFont( "Arial", "BU", 10 ); $pdf->SetXY( 5, 75 ) ; $pdf->Cell($pdf->GetStringWidth("Observations"), 0, "Observations", 0, "L");

        $pdf->SetFont('Arial','B',11); $x = 110 ; $y = 50;
        $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'NULL', 0, 0, ''); $y += 4;
        if (NULL) { $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'NULL', 0, 0, ''); $y += 4;}
        if (NULL) { $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'NULL', 0, 0, ''); $y += 4;}
        if (NULL) { $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'NULL', 0, 0, ''); $y += 4;}
        if (NULL) { $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'NULL' . ' ' .'NULL' , 0, 0, ''); $y += 4;}
        if (NULL) { $pdf->SetXY( $x, $y ); $pdf->Cell( 100, 8, 'N° TVA Intra : ' . 'NULL', 0, 0, '');}
        
        $pdf->SetLineWidth(0.1); $pdf->Rect(5, 95, 200, 118, "D");

        $pdf->Line(5, 105, 205, 105);

        $pdf->Line(145, 95, 145, 213); $pdf->Line(158, 95, 158, 213); $pdf->Line(176, 95, 176, 213); $pdf->Line(187, 95, 187, 213);

        $pdf->SetXY( 1, 96 ); $pdf->SetFont('Arial','B',8); $pdf->Cell( 140, 8, utf8_decode("Libellé"), 0, 0, 'C');
        $pdf->SetXY( 145, 96 ); $pdf->SetFont('Arial','B',8); $pdf->Cell( 13, 8, utf8_decode("Qté"), 0, 0, 'C');
        $pdf->SetXY( 156, 96 ); $pdf->SetFont('Arial','B',8); $pdf->Cell( 22, 8, "PU HT", 0, 0, 'C');
        $pdf->SetXY( 177, 96 ); $pdf->SetFont('Arial','B',8); $pdf->Cell( 10, 8, "TVA", 0, 0, 'C');
        $pdf->SetXY( 185, 96 ); $pdf->SetFont('Arial','B',8); $pdf->Cell( 22, 8, "TOTAL HT", 0, 0, 'C');
        
        $pdf->SetFont('Arial','',8);
        $y = 97;

        $pdf->SetXY( 7, $y+9 ); $pdf->Cell( 140, 5, 'Abonnement '. utf8_decode($data['subscribe_name']), 0, 0, 'L');
        $pdf->SetXY( 145, $y+9 ); $pdf->Cell( 13, 5, 1, 3, ' ', true, 0, 0, 'R');

        $nombre_format_francais = number_format($data['subscribe_price'] - ($data['subscribe_price'] / 100 * 5.5), 2, ',', ' ');
        $pdf->SetXY( 158, $y+9 ); $pdf->Cell( 18, 5, $nombre_format_francais, 0, 0, 'R');

        $nombre_format_francais = number_format(($data['subscribe_price'] / 100 * 5.5), 2, ',', ' ');
        $pdf->SetXY( 177, $y+9 ); $pdf->Cell( 10, 5, $nombre_format_francais, 0, 0, 'R');
        
        $nombre_format_francais = number_format($data['subscribe_price'] - ($data['subscribe_price'] / 100 * 5.5), 2, ',', ' ');
        $pdf->SetXY( 187, $y+9 ); $pdf->Cell( 18, 5, $nombre_format_francais, 0, 0, 'R');
        
        $pdf->Line(5, $y+14, 205, $y+14);
            

        $nombre_format_francais = utf8_decode("Net à payer TTC : ") . number_format($data['subscribe_price'], 2, ',', ' ') . ' '. EURO;
        $pdf->SetFont('Arial','B',12); $pdf->SetXY( 5, 213 ); $pdf->Cell( 90, 8, $nombre_format_francais, 0, 0, 'C');

        $nombre_format_francais = "Total TVA : " . number_format(($data['subscribe_price'] / 100 * 5.5) , 2, ',', ' ') . ' '. EURO;
        $pdf->SetFont('Arial','',10); $pdf->SetXY( 158, 213 ); $pdf->Cell( 47, 8, $nombre_format_francais, 0, 0, 'C');

        $pdf->SetY(-15);
        $pdf->SetFont('Arial','I',8);
        $pdf->Cell(0,10,'(c) One More Training',0,0,'C');
    
    $pdf->Output("D", $nom_file);
}
?>