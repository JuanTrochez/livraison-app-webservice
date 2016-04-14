<?php

include_once '/class/Livraison.php';
include_once '/function/geo.php';

header('Content-Type: application/json; charset=utf-8');

$return = array();

$return['infos']['data'] = 'livraison';
$return['infos']['valide'] = false;
$return['infos']['message'] = 'Error while getting delivery';

$idLivreur = 1;
$posLat = 48.8459535;
$posLng = 2.354859;

$livraison = new Livraison();
$dayLivraison = $livraison->getDailyLivraisonByLivreur($bdd, $idLivreur);
$lastDaysLivraison = $livraison->getLastDaysLivraisonByLivreur($bdd, $idLivreur);

$allLivraisons = Geolocation::sortArrayByDistances($bdd, $lastDaysLivraison, $dayLivraison, $posLat, $posLng);

if ($allLivraisons['valide']) {    
    $return['data']['livraisons'] = $allLivraisons['livraison'];
    $return['infos']['valide'] = true;
    $return['infos']['message'] = "Delivery successfully added";
} 

echo json_encode(utf8ize($return), JSON_UNESCAPED_UNICODE);
