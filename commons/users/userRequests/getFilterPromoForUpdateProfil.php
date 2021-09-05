<?php
require_once '../../../requests/select.php';

function getPromoChartFilterForUpdateProfil(){
    $idEcole = $_REQUEST['idEcole'];
    echo json_encode(selectPromoBySchoolsId($idEcole));
}

getPromoChartFilterForUpdateProfil();
