<?php
require_once '../requests/select.php';

function getPromoChartPartMois(){
    $idPromo = $_REQUEST['idPromo'];
    $json = json_encode(selectPartMoisByIdPromo($idPromo));
    echo $json;
}

getPromoChartPartMois();