<?php
require_once '../requests/select.php';


function getIdCours(){
    $json = json_encode(selectLogs());
    echo($json);
}

getIdCours();