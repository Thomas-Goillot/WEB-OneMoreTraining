<?php
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

$actual_page = "payment.php";    

include('../includes/include-session-check.php');

include('../includes/include-functions.php');

require_once('stripe-php/init.php');

$id = $_GET['id'];

if(!isset($id) || $id < 3) {
    header("Location: ../index.php");
}

$query = $bdd->prepare("SELECT * FROM SUBSCRIBE WHERE id_subscribe = ?");
$query->execute(array($id));
$article = $query->fetch();

if(!$article) {
    header("Location: ../index.php");
} 


\Stripe\Stripe::setApiKey('sk_test_51KwZwsKXvWP2sUh1r87VxFFkCclxcv06Skfw7YZX6TuG6JqtRYI0X1U4x4lZdiCnoLCyB5ckyi6jtJqGg626IsSS00t4BDBIDd');

header('Content-Type: application/json');

$domain = ''.checkhost().$_SERVER['HTTP_HOST'];

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    'price_data' => [
      'currency' => 'eur',
      'product_data' => [
        'name' => $article['subscribe_name'],
      ],
      'unit_amount' => $article['subscribe_price'] * 100,
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $domain . '/payment/success.php?id=' . $id,
  'cancel_url' => $domain,
]);


header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
