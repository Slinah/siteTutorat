<?php
require_once '../requests/select.php';

function getPromoChartFilterQuestion(){
    $idMatiere = $_REQUEST['idMatiere'];
    $json = json_encode(selectQuestionByIdPromo($idMatiere));
    echo $json;
}

getPromoChartFilterQuestion();