<?php
require_once '../requests/select.php';

function getGlobalChart(){
    $json = json_encode(selectTuteurCoursClosHeures());
    echo $json;
}

getGlobalChart();