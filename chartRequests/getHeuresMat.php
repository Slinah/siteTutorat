<?php
require_once '../requests/select.php';

function getPromoChartHeuresMat(){
    $idPromo = $_REQUEST['idPromo'];
    $json = json_encode(selectMatieresHeuresByFakeIdPromo($idPromo));
    echo $json;
}

getPromoChartHeuresMat();