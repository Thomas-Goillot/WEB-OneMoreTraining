<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-functions.php');
include('../includes/include-bdd.php');

$captcha_image = dirname(__DIR__, 1) . "/assets/img/captcha/" . random_img('../assets/img/captcha/');

$infos_captcha_image = getimagesize($captcha_image);

switch($infos_captcha_image["mime"]) {
    case "image/png":
        $image_source = imagecreatefrompng($captcha_image);
        break;

    case "image/jpeg":
        $image_source = imagecreatefromjpeg($captcha_image);
        break;
    
    default:
        die("Format d'image incorect");

    }

$width_each_captcha_image = $infos_captcha_image[0] / 3;
$height_each_captcha_image = $infos_captcha_image[1] / 3;

$tab = [];

$counter = 0;
for ($y=0; $y < 3 ; $y++) { 
    for ($x=0; $x < 3 ; $x++) { 

        $newimage = imagecrop($image_source,
        [
            "x" => $x * $width_each_captcha_image,
            "y" => $y * $height_each_captcha_image,
            "width" => $width_each_captcha_image,
            "height" => $height_each_captcha_image
        ]);

        array_push($tab,['id' => $counter, 'img' => img_encode($newimage)]);
        $counter++;
    }
}  

show($tab);

function img_encode($newimage){

    ob_start();

    imagejpeg($newimage, NULL, 100);

    return ob_get_clean();
}

function show($order_img) {

    shuffle($order_img);
    
    for ($i=0; $i < count($order_img) ; $i++) { 
        echo "<div class='container-fluid mx-0 px-0 col-4 border rounded captcha-div'><img id='test' class='img-fluid w-100 draggable' draggable='true' value='".sm_hash($order_img[$i]['id'])."' src='data:image/jpeg;base64," . base64_encode($order_img[$i]['img']) . "' /></div>";
    }
    
}



?>