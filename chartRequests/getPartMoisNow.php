<?php
require_once '../requests/select.php';

function getPromoChartPartMois(){
    $fakeidPromo = $_REQUEST['fakeidPromo'];
    $json = json_encode(selectPartMoisByFakeIdPromo($fakeidPromo));
    echo $json;
}

getPromoChartPartMois();