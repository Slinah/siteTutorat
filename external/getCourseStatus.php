<?php
require_once '../requests/select.php';


function getCourseStatus(){
    $json = json_encode(selectCoursStatus());
    echo($json);
}

getCourseStatus();