<?php
require_once '../../../requests/select.php';

function getPromoChartFilterQuestion(){
    $idMatiere = $_REQUEST['idMatiere'];
    // on récupère le template json et on le parse en objet PHP
    // on devrait peut être utiliser directement un objet PHP plutôt que de transformer
    // le fichier json en php pour le retransfromer plus loin en json à nouveau
    $tableObject = json_decode(file_get_contents("templateQuestionForum.json"));
    // on ajoutes les données dans "data"
    $tableObject->data = selectQuestionByIdPromo($idMatiere);
    echo json_encode($tableObject);
}

getPromoChartFilterQuestion();