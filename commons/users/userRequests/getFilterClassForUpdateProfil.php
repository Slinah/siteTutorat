<?php
require_once '../../../requests/select.php';

function getClassChartFilterForUpdateProfil(){
    $idPromo = $_REQUEST['idPromo'];
    // on récupère le template json et on le parse en objet PHP
    echo json_encode(selectClassByPromo($idPromo));
}

getClassChartFilterForUpdateProfil();
