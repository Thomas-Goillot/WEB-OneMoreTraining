<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-functions.php');

$res = "val:Vous n'êtes pas un robot !";
for ($i=0; $i <= 8 ; $i++) {
    $value = htmlspecialchars($_GET['val'.$i.'']);
    if($value !== sm_hash($i)){
        $res = 'err:Êtes vous sur de ne pas être un robot ?';
    }
} 
echo $res;


?>