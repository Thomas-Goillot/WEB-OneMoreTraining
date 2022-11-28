<?php
$error = $_SERVER['REDIRECT_STATUS'];
$numbers = str_split($error);

$http_codes = [
    100 => 'Continuez',
    101 => 'Protocoles de commutation',
    102 => 'Traitement en cours',
    103 => 'Point de contrôle',
    200 => 'OK',
    201 => 'Créé',
    202 => 'Accepté',
    203 => 'Informations ne faisant pas autorité',
    204 => 'Pas de contenu',
    205 => 'Contenu réinitialisé',
    206 => 'Contenu partiel',
    207 => 'Multi-Statut',
    300 => 'Choix multiples',
    301 => 'Déménagé définitivement',
    302 => 'Trouvé',
    303 => 'Voir d\'autres',
    304 => 'Non modifié',
    305 => 'Use Proxy',
    306 => 'Changer de proxy',
    307 => 'Redirection temporaire',
    400 => 'Mauvaise demande',
    401 => 'Non autorisé',
    402 => 'Paiement Requis',
    403 => 'Vous n\'avez pas les permissions pour accéder à cette page',
    404 => 'Page introuvable',
    405 => 'Méthode Non Autorisée',
    406 => 'Pas acceptable',
    407 => 'Authentification proxy requise',
    408 => 'Délai d\'expiration de la demande',
    409 => 'Conflict',
    410 => 'Disparu',
    411 => 'Longueur requise',
    412 => 'Échec de la condition préalable',
    413 => 'Entité de requête trop grande',
    414 => 'Demande-URI trop long',
    415 => 'Type de support non pris en charge',
    416 => 'Plage demandée non satisfaisante',
    417 => 'Échec de l\'attente',
    418 => 'Je suis une théière',
    422 => 'Entité non traitable',
    423 => 'Fermé',
    424 => 'Échec de la dépendance',
    425 => 'Collection non ordonnée',
    426 => 'Mise à niveau requise',
    449 => 'Réessayer avec',
    450 => 'Bloqué par le contrôle parental de Windows',
    500 => 'Erreur Interne du Serveur',
    501 => 'Pas mis en œuvre',
    502 => 'Mauvaise passerelle',
    503 => 'Service indisponible',
    504 => 'Délai d\'expiration dépassé de la passerelle',
    505 => 'Version HTTP non prise en charge',
    506 => 'La variante négocie également',
    507 => 'Espace insuffisant',
    509 => 'Limite de bande passante dépassée',
    510 => 'Non étendu'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$error?></title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <style>
    * {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        padding: 0;
        margin: 0;
    }

    #error {
        position: relative;
        height: 100vh;
        background-color: #222;
    }

    #error .error {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .error {
        max-width: 460px;
        width: 100%;
        text-align: center;
        line-height: 1.4;
    }

    .error .errors {
        height: 158px;
        line-height: 153px;
    }

    .error .errors h1 {
        font-family: 'Josefin Sans', sans-serif;
        color: #222;
        font-size: 220px;
        letter-spacing: 10px;
        margin: 0px;
        font-weight: 700;
        text-shadow: 2px 2px 0px #c9c9c9, -2px -2px 0px #c9c9c9;
    }

    .error .errors h1>span {
        text-shadow: 2px 2px 0px #ffab00, -2px -2px 0px #ffab00, 0px 0px 8px #ff8700;
    }

    .error p {
        font-family: 'Josefin Sans', sans-serif;
        color: #c9c9c9;
        font-size: 16px;
        font-weight: 400;
        margin-top: 0px;
        margin-bottom: 15px;
    }

    .error a {
        font-family: 'Josefin Sans', sans-serif;
        font-size: 14px;
        text-decoration: none;
        text-transform: uppercase;
        background: transparent;
        color: #c9c9c9;
        border: 2px solid #c9c9c9;
        display: inline-block;
        padding: 10px 25px;
        font-weight: 700;
        -webkit-transition: 0.2s all;
        transition: 0.2s all;
    }

    .error a:hover {
        color: #ffab00;
        border-color: #ffab00;
    }

    @media only screen and (max-width: 480px) {
        .error .errors {
            height: 122px;
            line-height: 122px;
        }

        .error .errors h1 {
            font-size: 122px;
        }
    }
    </style>
</head>

<body>
    <div id="error">
        <div class="error">
            <div class="errors">
                <h1><?=$numbers[0]?><span><?=$numbers[1]?></span><?=$numbers[2]?></h1>
            </div>
            <p><?= $http_codes[$error]?>
            </p>
            <a href="/">page Principale</a>
        </div>
    </div>

</body>

</html>