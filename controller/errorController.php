<?php


header('Content-Type: application/json');

$data = ['valid' => false, 'message' => 'Error: Request not found'];


echo json_encode($data);
