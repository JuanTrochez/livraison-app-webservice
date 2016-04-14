<?php

include_once '/class/Livraison.php';
include_once '/function/geo.php';

header('Content-Type: application/json; charset=utf-8');

$return = array();

$return['infos']['valide'] = false;
$return['infos']['message'] = 'Error while getting livraisons';

$idLivreur = 1;
$posLat = 48.8459535;
$posLng = 2.354859;

$livraison = new Livraison();
$dayLivraison = $livraison->getDailyLivraisonByLivreur($bdd, $idLivreur);
$lastDaysLivraison = $livraison->getLastDaysLivraisonByLivreur($bdd, $idLivreur);
//
//$return['livraison']['today'] = $dayLivraison;
//$return['livraison']['lastDay'] = $lastDaysLivraison;
//var_dump($return['livraison']);



$allLivraisons = Geolocation::sortArrayByDistances($lastDaysLivraison, $dayLivraison, $posLat, $posLng);
$return['data']['livraisons'] = $allLivraisons;


//var_dump($return);


//var_dump($dayLivraison);
//var_dump($lastDaysLivraison);

//$distances = Geolocation::GetDrivingDistance($lat1, $lat2, $long1, $long2);
//var_dump($distances);


echo json_encode(utf8ize($return), JSON_UNESCAPED_UNICODE);
