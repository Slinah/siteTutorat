<?php
require_once '../requests/select.php';


function getCoursProfByLogs(){
    $course = $_GET['course'];
    $json = json_encode(selectCourseProfByLogs($course));
    echo($json);
}

getCoursProfByLogs();