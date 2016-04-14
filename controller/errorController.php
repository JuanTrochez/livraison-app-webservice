<?php

header('Content-Type: application/json');
$return = array();
$return['data'] = array();
$return['hello'] = 'hi';

$return['infos']['valid'] = false;
$return['infos']['message'] = 'Error: Request not found';


if (isset($_GET['test']) && !empty($_GET['test'])) {
    $return['data']['test'] = 'Izi money';
}



echo json_encode($return);
