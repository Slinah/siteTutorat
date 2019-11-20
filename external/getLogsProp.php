<?php
require_once '../requests/select.php';


function getIdProp(){
    $json = json_encode(selectLogsProp());
    echo($json);
}

getIdProp();