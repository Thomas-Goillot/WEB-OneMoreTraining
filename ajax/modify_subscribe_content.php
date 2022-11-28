<?php 
/*
 * Created on Mon Apr 04 2022
 *
 * Copyright (c) 2022 Thomas GOILLOT
 */

include('../includes/include-bdd.php');

    $id_subscribe = htmlspecialchars($_GET['id_subscribe']);
    $column = htmlspecialchars($_GET['column_name']);
    $new_value = htmlspecialchars($_GET['val']);
    
switch ($column) {
    case 'subscribe_name':
        $modify_subscribe = $bdd->prepare("UPDATE SUBSCRIBE SET subscribe_name = ? WHERE id_subscribe = ?");
        break;
    case 'subscribe_price':
        $modify_subscribe = $bdd->prepare("UPDATE SUBSCRIBE SET subscribe_price = ? WHERE id_subscribe = ?");
        break;

    default:
        echo "erreur dans le nom de la colonne";
        break;
}

$modify_subscribe->execute(array($new_value,$id_subscribe));


?>