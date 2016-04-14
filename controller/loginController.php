<?php

include_once '/class/Livreur.php';

header('Content-Type: application/json');

$return = array();
$return['infos'] = array();
$return['data'] = array();

$return['infos']['data'] = 'login';
$return['infos']['valide'] = false;


if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = base64_decode($_GET['token']);
    $return['data']['token'] = $token;
    $return['infos']['valide'] = true;
}


echo json_encode($return);

