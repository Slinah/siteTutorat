<?php
require_once '../requests/select.php';

function getGlobalChart(){
    $json = json_encode(selectHeuresMatièresCoursClos());
    echo $json;
}

getGlobalChart();