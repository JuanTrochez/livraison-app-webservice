<?php
    include_once 'function/bdd.php';
    include_once 'function/geo.php';
    
    
    $lat1 = 48.8459535;
    $long1 = 2.354859;
    
    $lat2 = 48.8404955;
    $long2 = 2.2560035;
    
//    var_dump(Geolocation::GetDrivingDistance($lat1, $lat2, $long1, $long2));exit;

    $basePath = "http://" . $_SERVER["SERVER_NAME"] . "/livraison-app-webservice/";

    // si une page est demandée avec '?p=pageDemandee' (dans l'url)
    if(isset($_GET['json']) && !empty($_GET['json']) && preg_match("/^[a-zA-Z0-9-]+$/i",$_GET['json'])){
            $p = htmlspecialchars(htmlentities($_GET['json']));

            // Vérifie si le fichier existe avant inclusion
            if(file_exists('controller/' . $p . 'Controller.php')){

                    include_once 'controller/' . $p . 'Controller.php'; // Inclusion du controller de la page

            }else{// sinon renvoi une erreur si la requete n'existe pas

                     include_once 'controller/errorController.php'; // Inclusion du controller error
            }

    } else {
         include_once 'controller/errorController.php'; // Inclusion du controller error
    }

?>
