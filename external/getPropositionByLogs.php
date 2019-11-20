<?php
require_once '../requests/select.php';


function gePropByLogs()
{
    $prop = $_GET['prop'];
    $json = json_encode(selectPropositionByLogs($prop));
    echo ($json);
}

gePropByLogs();
