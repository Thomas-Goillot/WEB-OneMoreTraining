<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */


function days_in_month($month, $year){
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

function pwd_hash($pwd){
    $salt = "oneMoretrainingSalt";

    for ($i=0; $i < 10 ; $i++) {
        $pwd = hash('sha512',$salt . $pwd);
    }
    return $pwd;
}

function sm_hash($text){
    return hash('sha512',$text);
}

function add_filigrane($fichier_import,$folder){
    //$fichier_import == name of file
    $image_import = dirname(__DIR__, 1) . "/assets/img/$folder/" . $fichier_import;
    
    $infos_import = getimagesize($image_import);
    
    switch($infos_import["mime"]) {
        case "image/png":
            $image_source = imagecreatefrompng($image_import);
            break;
    
        case "image/jpeg":
            $image_source = imagecreatefromjpeg($image_import);
            break;
        
        default:
            die("Format d'image incorrect");
    
        }
    
    
    $path_logo = dirname(__DIR__, 1) . "/assets/img/filigrane_black.png";
    
    $logo = imagecreatefrompng($path_logo);
    
    $infos_logo = getimagesize($path_logo);
    
    imagecopyresampled(
        $image_source,
        $logo,
        $infos_import[0] - $infos_logo[0] - 10,
        $infos_import[1] - $infos_logo[1] - 10,
        0,
        0,
        $infos_logo[0],
        $infos_logo[1],
        $infos_logo[0],
        $infos_logo[1]
    );
    
    switch($infos_import["mime"]) {
        case 'image/png':
            imagepng($image_source, dirname(__DIR__, 1) . "/assets/img/".$folder."/".$fichier_import);
            break;
        case 'image/jpeg':
            imagejpeg($image_source, dirname(__DIR__, 1) . "/assets/img/".$folder."/".$fichier_import);
            break;
    }
    
    imagedestroy($image_source);
    imagedestroy($logo);
    
    }

    function get_badge($int,$icon_badge){
        $int_array = str_split($int);
        $res = '<button class="btn btn-success mx-1 mb-2 mt-2">'.$icon_badge.' ';
        for ($i=0; $i < count($int_array) ; $i++) { 
            $res = $res.'<i class="fa-solid fa-'.$int_array[$i].'"></i>';
        }
        $res = $res.'</button>';
        return $res;
    }

    function get_admin_badge($val){
        switch ($val) {
            case 0:
                //User is not admin
                return "<button class='btn btn-primary' disabled>User</button>";
                break;
            case 1:
                //User is admin
                return "<button class='btn btn-info px-1' disabled>Admin</button>";
                break;
            
            default:
                return "Not a valid Permission level!";
                break;
        }
    }

    function get_group_status($val){
        switch ($val) {
            case 1:
                //User is in the group
                return "<button class='btn btn-success' disabled>Member</button>";
                break;
            case 2:
                //User confirmation is pending
                return "<button class='btn btn-warning' disabled>Pending</button>";
                break;
            case 3:
                //User is ban from the group
                return "<button class='btn btn-danger' disabled>Banned</button>";
                break;            
            default:
                return "Not a valid status level!";
                break;
        }
    }

    function get_training_privacy($val){
        //cf readme.md
        switch ($val) {
            case 1:
                return "<button class='btn btn-info' disabled>Publique</button>";
                break;
            case 2:
                return "<button class='btn btn-info' disabled>Amis seulement</button>";
                break;
            case 3:
                return "<button class='btn btn-info' disabled>Privé</button>";
                break;            
            default:
                return "Not a valid privacy level!";
                break;
        }
    }

    function get_gender($type){
        switch ($type) {
            case 'm':
                return "Homme";
                break;
            case 'f':
                return "Femme";
                break;
            
            default:
                return "Autres";
                break;
        }
    }

    function random_img($dir){

        $imgs_arr = array();
    
        if (file_exists($dir) && is_dir($dir) ) {
    
          $dir_arr = scandir($dir);
          $arr_files = array_diff($dir_arr, array('.','..') );
    
            foreach ($arr_files as $file) {
    
            $file_path = $dir."/".$file;
    
            $ext = pathinfo($file_path, PATHINFO_EXTENSION);
    
                if ($ext=="jpg" || $ext=="png" || $ext=="JPG" || $ext=="PNG") {
    
                    array_push($imgs_arr, $file);
    
                }
            }
    
            $count_img_index = count($imgs_arr) - 1;
    
            return $imgs_arr[rand( 0, $count_img_index )];
        }
    }

    function load_avatar($bdd, $id, $width = NULL, $height = NULL){
        $req = $bdd->prepare('SELECT id_user FROM AVATAR WHERE id_user = ?');
        $req->execute(array($id));
        $avatar = $req->rowCount();
    
        if ($avatar != 0) {

            $req = $bdd->prepare('SELECT * FROM AVATAR WHERE id_user = ?');
            $req->execute(array($id));
            $avatar = $req->fetch();

            $head = dirname(__DIR__, 1) . '/assets/img/avatar/'.$avatar['head'].'';
            $eyes = dirname(__DIR__, 1) . '/assets/img/avatar/'.$avatar['eyes'].'';
            $nose = dirname(__DIR__, 1) . '/assets/img/avatar/'.$avatar['nose'].'';
            $mouth = dirname(__DIR__, 1) . '/assets/img/avatar/'.$avatar['mouth'].'';
            $brows = dirname(__DIR__, 1) . '/assets/img/avatar/'.$avatar['brows'].'';
            
            $x = 733; 
            $y = 929;
        
            $final_img = imagecreatetruecolor($x, $y);
        
            $white = imagecolorallocatealpha($final_img, 0, 0, 0, 127); 
            imagefill($final_img,0,0,$white); 
            imagesavealpha($final_img, true); 
        
        
            $image_1 = imagecreatefrompng($head);
        
            $image_2 = imagecreatefrompng($eyes);
        
            $image_3 = imagecreatefrompng($nose);
        
            $image_4 = imagecreatefrompng($mouth);
        
            $image_5 = imagecreatefrompng($brows);
        
            imagecopyresampled($final_img, $image_1, 0, 0, 0, 0, $x, $y, $x, $y);
            imagecopyresampled($final_img, $image_2, 0, 0, 0, 0, $x, $y, $x, $y);
            imagecopyresampled($final_img, $image_3, 0, 0, 0, 0, $x, $y, $x, $y);
            imagecopyresampled($final_img, $image_4, 0, 0, 0, 0, $x, $y, $x, $y);
            imagecopyresampled($final_img, $image_5, 0, 0, 0, 0, $x, $y, $x, $y);
        
            ob_start();
        
                
            imagepng($final_img);
            $avatar_img = ob_get_contents();
            ob_end_clean();

            if($width != NULL && $height != NULL){
                return '<img src="data:image/png;base64,'.base64_encode($avatar_img).'" alt="Avatar" width="'.$width.'" height="'.$height.'" class="img-fluid rounded-pill">';
            }
            else{
                return '<img src="data:image/png;base64,'.base64_encode($avatar_img).'" alt="Avatar" class="img-fluid rounded-pill">';
            }

        } else {
            if($width != NULL && $height != NULL){
                return '<img src="/assets/img/user/user.png" alt="Default Avatar" width="'.$width.'" height="'.$height.'" class="img-fluid rounded-pill">';
            }
            else{
                return '<img src="/assets/img/user/user.png" alt="Default Avatar" class="img-fluid rounded-pill">';
            }
        }
    }  

    function checkhost(){
        if($_SERVER['HTTP_HOST'] == "localhost:81" || $_SERVER['HTTP_HOST'] == "localhost"){
            $host = "http://";
        }else{
            $host = "https://";
        }
        return $host;
    }

    function obtenirLibelleMois($mois){
        if($mois == '01'){
            $mois = 'Janvier';
        }
        elseif($mois == '02'){
            $mois = 'Février';
        }
        elseif($mois == '03'){
            $mois = 'Mars';
        }
        elseif($mois == '04'){
            $mois = 'Avril';
        }
        elseif($mois == '05'){
            $mois = 'Mai';
        }
        elseif($mois == '06'){
            $mois = 'Juin';
        }
        elseif($mois == '07'){
            $mois = 'Juillet';
        }
        elseif($mois == '08'){
            $mois = 'Août';
        }
        elseif($mois == '09'){
            $mois = 'Septembre';
        }
        elseif($mois == '10'){
            $mois = 'Octobre';
        }
        elseif($mois == '11'){
            $mois = 'Novembre';
        }
        elseif($mois == '12'){
            $mois = 'Decembre';
        }
        return $mois;
    }

    function literalDate($date){
        $date = explode('-', $date);
        $mois = obtenirLibelleMois($date[1]);
        $date = $date[2].' '.$mois.' '.$date[0];
        return $date;
    }
    
    //FOR DEV PURPOSE
    function vardump($var){
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    
    //Shop Copyright (c) 2022 Victor STEC
    function display($bdd)
    {
       
          $req=$bdd->prepare("SELECT * FROM PRODUCT WHERE quantity>0 ORDER BY id_product DESC");

            $req->execute();

            $data = $req->fetchAll(PDO::FETCH_OBJ);

            return $data;

            $req->closeCursor();
       
    }        
?>