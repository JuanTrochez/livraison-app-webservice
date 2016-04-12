<?php

include_once '/class/Livraison.php';

$idLivreur = 1;
$livraison = new Livraison();
$dayLivraisons = $livraison->getDailyLivraisonByLivreur($bdd, $idLivreur);

//var_dump($dayLivraisons);

$distances = Geolocation::GetDrivingDistance($lat1, $lat2, $long1, $long2);
//var_dump($distances);

echo "page livraison";
