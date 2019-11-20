<?php
require_once '../requests/select.php';

function getPercentPartMat(){
    $idPromo = $_REQUEST['idPromo'];
    $json = json_encode(selectParticipantsMatiereByIdPromo($idPromo));
    echo $json;
}

getPercentPartMat();