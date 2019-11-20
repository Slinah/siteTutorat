<?php
require_once '../requests/select.php';


function getCours(){
    $json = json_encode(selectCoursStatus());
    echo($json);
}

getCours();