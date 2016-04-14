<?php

class Geolocation {
    
    public static function sortArrayByDistances($bdd, $lastDaysLivraison, $dayLivraison, $posLat, $posLng) {
        $result = array(
            "currentTime" => 0,
            "livraison" => array()
        );
        $maxTime = 28800;//8h en secondes
        
        if (count($lastDaysLivraison)) {
            foreach ($lastDaysLivraison as $value) {
                //on verifie que le temps ne depasse pas les 8h avant l'ajout de la livraison
                $result['currentTime'] += $value['duration'];
                if ($result['currentTime'] > $maxTime) {
                    $result['currentTime'] -= $value['duration'];
                    break;
                }
                
                $value['detail'] = Livraison::getDetailLivraison($bdd, $value['client_id']);
                
                $distance = Geolocation::GetDrivingDistance($posLat, $value['latitude'], $posLng, $value['longitude']);
                $value['distance'] = $distance['distance'];
                $value['time'] = $distance['time'];
                
                $result['livraison']['priority'][] = $value;
            }            
        }
        
        //on gère les livraisons du jour si la liste n'a pas encore depassé les 8h
        if ($result['currentTime'] < $maxTime && count($dayLivraison)) {
                foreach ($dayLivraison as $value) {
                    
                    //on verifie que le temps ne depasse pas les 8h avant l'ajout de la livraison
                    $result['currentTime'] += $value['duration'];
                    if ($result['currentTime'] > $maxTime) {
                        $result['currentTime'] -= $value['duration'];
                        break;
                    }
                    
                    $value['detail'] = Livraison::getDetailLivraison($bdd, $value['client_id']);
                    
                    $distance = Geolocation::GetDrivingDistance($posLat, $value['latitude'], $posLng, $value['longitude']);
                    $value['distance'] = $distance['distance'];
                    $value['time'] = $distance['time'];
                    $result['livraison']['day'][] = $value;
                }
        }
        
        $result['livraison']['day'] = Geolocation::array_sort($result['livraison']['day'], 'distance', SORT_ASC);
        $result['valide'] = true;
        
        return $result;
        
    }
    
    public static function array_sort($array, $on, $order=SORT_ASC)    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    
    //retourne la distance en metre et le temps en seconde entre chaque coordonnees
    public static function GetDrivingDistance($lat1, $lat2, $long1, $long2) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=fr-FR";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
//        var_dump($response_a);
        $dist['value'] = $response_a['rows'][0]['elements'][0]['distance']['value'];
        $dist['text'] = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['value'];

        return array('distance' => $dist['value'], 'distanceText' => $dist['text'], 'time' => $time);
    }

}
