<?php

function getMois($date)
{
    $tabMois = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    (int) $mois = date("m", strtotime($date));

    switch ($mois) {
        case '01':
            $mois = 0;
            break;
        case '02':
            $mois = 1;
            break;
        case '03':
            $mois = 2;
            break;
        case '04':
            $mois = 3;
            break;
        case '05':
            $mois = 4;
            break;
        case '06':
            $mois = 5;
            break;
        case '07':
            $mois = 6;
            break;
        case '08':
            $mois = 7;
            break;
        case '09':
            $mois = 8;
            break;
        case '10':
            $mois = 9;
            break;
        case '11':
            $mois = 10;
            break;
        case '12':
            $mois = 11;
            break;
    }
    
    return $tabMois[$mois];
}
