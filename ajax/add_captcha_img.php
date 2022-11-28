<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-functions.php');

if($_FILES['image_captcha']['error'] != 4){

    $acceptable = ['image/jpeg','image/png'];

    if(in_array($_FILES['image_captcha']['type'], $acceptable)){
        $maxSize = 2 * 1024 * 1024; // 2Mo

        if($_FILES['image_captcha']['size'] < $maxSize){

            // Si le dossier product n'esist pas, le créer
            $path = '../assets/img/captcha';
            if(!file_exists($path)){
                mkdir($path, 0777); // chmod 777
            }
        
            $filename = htmlspecialchars($_FILES['image_captcha']['name']);

            $array = explode('.', $filename);
            $extension = end($array);
        
            $filename = 'captcha-' . time() . '.' . $extension;
        
            $destination = $path . '/' . $filename;

            move_uploaded_file($_FILES['image_captcha']['tmp_name'], $destination);

            add_filigrane($filename,"captcha");

            echo "val:L'image à été ajouté avec succés";
        }
        else{
            echo "err:L'image ne doit pas dépasser 2Mo";
        }
    }
    else{
        echo "err:Type d'image incorrect";
    }
}
else{
    echo "err:Pas d'image detecter";
}


?>