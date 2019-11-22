<?php
require_once '../requests/select.php';

function getPartInsc()
{
    $idPromo = $_REQUEST['idPromo'];
    $json = json_encode(selectInscritParticipantsCours($idPromo));
    echo $json;
}

getPartInsc();
