<?php
require_once '../requests/select.php';

function getPercentPartMat(){
    $idPromo = $_REQUEST['idPromo'];
    $json = json_encode(selectParticipantsMatiereByFakeIdPromo($idPromo));
    echo $json;
}

getPercentPartMat();