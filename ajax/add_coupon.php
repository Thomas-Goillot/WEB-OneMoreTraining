<?php 
// Copyright (c) 2022 Victor STEC

    include('../includes/include-bdd.php');
    include('../includes/include-functions.php');

    $code = htmlspecialchars($_POST['code']);
    $coupon_value = htmlspecialchars($_POST['coupon_value']);
    $exp_date =$_POST['exp_date'];

    if(!isset($code) || empty($code) || 
        !isset($coupon_value) || empty($coupon_value) || 
        !isset($exp_date) || empty($exp_date)){
                            
    $add = $bdd->prepare("INSERT INTO COUPON (code,coupon_value,exp_date) VALUES(:code,:coupon_value,:exp_date)");
    $add->execute(
    [
        'code' => $code,
        'coupon_value' => $coupon_value,
        'exp_date' => $exp_date 
    ]);
    }
    exit;              

?>