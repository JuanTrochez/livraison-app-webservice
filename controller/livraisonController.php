<?php

header('Content-Type: application/json; charset=utf-8');

$return = array();

$return['infos']['data'] = 'livraison';
$return['infos']['valide'] = false;
$return['infos']['message'] = 'Erreur lors de la recherche des livraisons';

$date = date('d-m-y');
$token = 'lol|403926033d001b5279df37cbbe5287b7c7c267fa|' . $date;
$token = base64_encode($token);
echo $token . ' ';


if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = base64_decode($_GET['token']);
    
    $array = explode('|',$token);
//    var_dump($array);
    $livreur = new Livreur();
    if (count($array) > 2) {
        
        $logged = $livreur->connect($bdd, $array[0], $array[1]);
        
        if ($logged['valide']) {
            $return['data'] = $logged['user'];
            
            $idLivreur = $logged['user']['id'];
            $posLat = 48.8459535;
            $posLng = 2.354859;

            $livraison = new Livraison();
            $dayLivraison = $livraison->getDailyLivraisonByLivreur($bdd, $idLivreur);
            $lastDaysLivraison = $livraison->getLastDaysLivraisonByLivreur($bdd, $idLivreur);

            $allLivraisons = Geolocation::sortArrayByDistances($bdd, $lastDaysLivraison, $dayLivraison, $posLat, $posLng);

            if ($allLivraisons['valide']) {    
                $return['data']['livraisons'] = $allLivraisons['livraison'];
                $return['infos']['valide'] = true;
                $return['infos']['message'] = "Les livraisons ont bien été ajoutées";
            } 
        } else {
            $data['infos']['message'] = "Le livreur n'a pas pu être connecté";
        }
    }

    
}




echo json_encode(utf8ize($return), JSON_UNESCAPED_UNICODE);
