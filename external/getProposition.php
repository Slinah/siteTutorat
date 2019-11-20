<?php
require_once '../requests/select.php';


function getProposition(){
    $json = json_encode(selectProposition());
    echo($json);
}

getProposition();