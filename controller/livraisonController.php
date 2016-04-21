<?php

header('Content-Type: application/json; charset=utf-8');

$return = array();

$return['infos']['data'] = 'livraison';
$return['infos']['valide'] = false;
$return['infos']['message'] = 'Erreur lors de la recherche des livraisons';

//$date = date('d-m-y');
//$token = 'lol|403926033d001b5279df37cbbe5287b7c7c267fa|' . $date;
//$token = base64_encode($token);
//echo $token . ' ';

if (isset($_POST) && !empty($_POST)) {
    var_dump($_POST);
}

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
            $produit = new Produit();
            $dayLivraison = $livraison->getDailyLivraisonByLivreur($bdd, $idLivreur);
            $lastDaysLivraison = $livraison->getLastDaysLivraisonByLivreur($bdd, $idLivreur);
            $updateLivraison = array();
            
            if (isset($_POST) && !empty($_POST)) {
                echo "hello post";
                $produitPost = $_POST;
                $size = count($produitPost) / 3;
                $livraisonListId = array(); 
                for ($index = 0; $index < $size; $index++) {
                    $produitId = $produitPost['id'.$index];
                    $produitStatut = $produitPost['statut'.$index];
                    $produitCommentaire = $produitPost['commentaire'.$index];
                    
                    $produit->updateProduitById($bdd, $produitId, $produitCommentaire, $produitStatut);
                    $currentProduit = $produit->getProduitById($bdd, $produitId);
                    if (!in_array($currentProduit['livraison_id'], $livraisonListId)) {
                        $livraisonListId[] = $currentProduit['livraison_id'];
                    }
                }
                
                //boucle sur la liste des livraisons généré pour envoyer les mises à jour
                foreach ($livraisonListId as $livraisonId) {                    
                    $produitStatut = array();
                    $currentLivraison = $livraison->getLivraisonById($bdd, $livraisonId);
                    $currentProduitList = $produit->getProduitByLivraison($bdd, $livraisonId);
                    foreach ($currentProduitList as $produitList => $value) {
                        $produitStatut[] = $produitList['statut'];
                    }
                    if (in_array(0, $produitStatut)) {
                        $livraison->updateLivraisonStatutById($bdd, $livraisonId, 0);
                    } else {
                        $livraison->updateLivraisonStatutById($bdd, $livraisonId, 1);
                    }
                    
                    //rafraichi le statut de la livraison et le met à jour
                    $livraisonUpdate = $livraison->getLivraisonById($bdd, $livraisonId);
                    $livraisonUpdate['detail'] = Livraison::getDetailLivraison($bdd, $livraisonId);
                    $distance = Geolocation::GetDrivingDistance($posLat, $livraisonUpdate['latitude'], $posLng, $livraisonUpdate['longitude']);
                    $livraisonUpdate['distance'] = $distance['distanceText'];
                    $updateLivraison[] = $livraisonUpdate;
                }
            }

            $allLivraisons = Geolocation::sortArrayByDistances($bdd, $lastDaysLivraison, $dayLivraison, $posLat, $posLng);

            if ($allLivraisons['valide']) {    
                $return['data']['livraisons'] = $allLivraisons['livraison'];
                $return['data']['livraisons']['update'] = $updateLivraison;
                $return['infos']['valide'] = true;
                $return['infos']['message'] = "Les livraisons ont bien été ajoutées";
            } 
        } else {
            $return['infos']['message'] = "Le livreur n'a pas pu être connecté";
        }
    }

    
}




echo json_encode(utf8ize($return), JSON_UNESCAPED_UNICODE);
