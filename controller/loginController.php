<?php

include_once '/class/Livreur.php';

header('Content-Type: application/json');

$return = array();
$return['infos'] = array();
$return['data'] = array();

//$date = date('d-m-y');
//$token = 'lol|lol|' . $date;
//$token = base64_encode($token);
//echo $token . ' ';

$return['infos']['data'] = 'login';
$return['infos']['valide'] = false;




if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = base64_decode($_GET['token']);
    
    $array = explode('|',$token);
//    var_dump($array);
    $livreur = new Livreur();
    if (count($array) > 2) {
        
        $logged = $livreur->connect($bdd, $array[0], $array[1]);
        if ($logged['valide']) {
            $return['infos']['valide'] = true;
            $return['data']['user'] = $logged['user'];
        }
    }

    
}


echo json_encode($return);

