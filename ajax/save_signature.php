<?php 
session_start();

$img = $_POST['image'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$fileData = base64_decode($img);
//saving
$fileName = '../assets/img/signatures/signature_'.$_SESSION['id_user'].'.png';
file_put_contents($fileName, $fileData);


?>