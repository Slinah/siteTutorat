<?php
require_once '../../../requests/select.php';

function getPromoChartFilterQuestion(){
    $idMatiere = $_REQUEST['idMatiere'];
    $checked = $_REQUEST['checked'];
    // on récupère le template json et on le parse en objet PHP
    // on devrait peut être utiliser directement un objet PHP plutôt que de transformer
    // le fichier json en php pour le retransfromer plus loin en json à nouveau
    //$tableObject = json_decode(file_get_contents("templateQuestionForum.json"));
    // on ajoutes les données dans "data"
    if($checked==1) {
        $tableObject = selectQuestionByIdMatiere($idMatiere);
    }else {
        $tableObject = selectQuestionByStatus(0);
    }
    echo json_encode($tableObject);
}

getPromoChartFilterQuestion();